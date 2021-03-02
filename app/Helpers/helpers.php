<?php
namespace App\Helpers;


use App\Models\PrsoCategory;
use App\Models\PrsoProduct as Catalog;
Use App\Http\Controllers\SparesApiController;
Use App\Http\Controllers\SparesController;
Use App\Http\Controllers\SparesNissController;
use DB;
use Cache;


class Helper
{
    public static function GetSparesName($SpareN)
    {
//       dd($SpareN);
        $SpareNames = DB::connection('tecdoc')
            ->table('articles')
            ->select('ART_ARTICLE_NR', 'SUP_BRAND', 'des_texts.TEX_TEXT as ART_COMPLETE_TEXT', 'DES_TEXTS2.TEX_TEXT as ART_DES_TEXT', 'DES_TEXTS3.TEX_TEXT as ART_STATUS_TEXT')
            ->join('designations', function ($join) {
                $join->on('designations.DES_ID', '=', 'ART_COMPLETE_DES_ID')
                    ->where('designations.DES_LNG_ID', '=', 16);
            })
            ->join('des_texts', 'des_texts.TEX_ID', '=', 'designations.DES_TEX_ID')
            ->leftJoin('designations as DESIGNATIONS2', function ($join) {
                $join->on('DESIGNATIONS2.DES_ID', '=', 'ART_DES_ID')
                    ->where('DESIGNATIONS2.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts as DES_TEXTS2', 'DES_TEXTS2.TEX_ID', '=', 'DESIGNATIONS2.DES_TEX_ID')
            ->join('suppliers', 'SUP_ID', '=', 'ART_SUP_ID')
            ->join('art_country_specifics', 'ACS_ART_ID', '=', 'ART_ID')
            ->join('designations as DESIGNATIONS3', function ($join) {
                $join->on('DESIGNATIONS3.DES_ID', '=', 'ACS_KV_STATUS_DES_ID')
                    ->where('DESIGNATIONS3.DES_LNG_ID', '=', 16);
            })
            ->join('des_texts as DES_TEXTS3', 'DES_TEXTS3.TEX_ID', '=', 'DESIGNATIONS3.DES_TEX_ID')
            ->where('ART_ID', $SpareN)
            ->get();

        return $SpareNames;
    }

    public static function GetSparesNameCrit($SpareN)
    {
//       dd($SpareN);
        $SpareNamesCriterias = DB::connection('tecdoc')
            ->table('article_criteria')
            ->select('des_texts.TEX_TEXT AS CRITERIA_DES_TEXT', DB::raw('IFNULL(DES_TEXTS2.TEX_TEXT, ACR_VALUE) AS CRITERIA_VALUE_TEXT'))
            ->leftJoin('designations AS DESIGNATIONS2', 'DESIGNATIONS2.DES_ID', '=', 'ACR_KV_DES_ID')
            ->leftJoin('des_texts AS DES_TEXTS2', 'DES_TEXTS2.TEX_ID', '=', 'DESIGNATIONS2.DES_TEX_ID')
            ->leftJoin('criteria', 'CRI_ID', '=', 'ACR_CRI_ID')
            ->leftJoin('designations', 'designations.DES_ID', '=', 'CRI_DES_ID')
            ->leftJoin('des_texts', 'des_texts.TEX_ID', '=', 'designations.DES_TEX_ID')
            ->where('ACR_ART_ID', $SpareN)
            ->where(function ($where) {
                $where->where('designations.DES_LNG_ID', NULL)
                    ->orwhere('designations.DES_LNG_ID', 16);
            })
            ->where(function ($where) {
                $where->where('DESIGNATIONS2.DES_LNG_ID', NULL)
                    ->orwhere('DESIGNATIONS2.DES_LNG_ID', 16);
            })
            ->get();

        return $SpareNamesCriterias;

    }

    public static function GetSparesTest($types, $STR_ID)
    {

        $Spares = DB::connection('tecdoc')
            ->table('link_ga_str')
            ->select('LA_ART_ID')
            ->join('link_la_typ', function ($join) use ($types) {
                $join->on('LAT_GA_ID', '=', 'LGS_GA_ID')
                    ->where('LAT_TYP_ID', '=', $types);
            })
            ->join('link_art', 'LA_ID', '=', 'LAT_LA_ID')
            ->where('LGS_STR_ID', $STR_ID)->get();

        return $Spares;
    }


    public static function GetSparesAnalog($SpareN, $Analog)
    {
        $Analog = Cache::get('DataAnalog');

        $SpareNamesAnalogs = DB::connection('tecdoc')
            ->table('art_lookup')
            ->select('ARL_KIND', DB::raw('IF (art_lookup.ARL_KIND = 2, suppliers.SUP_BRAND, brands.BRA_BRAND) AS BRAND'), 'ARL_DISPLAY_NR', 'ARL_BRA_ID')
            ->leftJoin('brands', 'BRA_ID', '=', 'ARL_BRA_ID')
            ->join('articles', 'articles.ART_ID', '=', 'art_lookup.ARL_ART_ID')
            ->join('suppliers', 'suppliers.SUP_ID', '=', 'articles.ART_SUP_ID')
            ->where('ARL_ART_ID', $SpareN)
            ->whereIn('ARL_KIND', [2, 3])
            ->get();


        // $CollAnalog = collect($SpareNamesAnalogs);
        // dd($SpareN,$CollAnalog);
        foreach ($SpareNamesAnalogs as $SpareNamesAnalog) {
//print_r($SpareNamesAnalog->ARL_DISPLAY_NR);
            $analognumber = camel_case($SpareNamesAnalog->ARL_DISPLAY_NR);
            $Analog = array_add($Analog, $analognumber, $SpareNamesAnalog->BRAND);
        }

        Cache::put('DataAnalog', $Analog, 30);
//dd($Analog);
        $InfoAnalogt = Cache::get('DataAnalog');
//        dd($InfoAnalogt);
        return $InfoAnalogt;

    }

    public static function CatalogItemPrice($cart_p)
    {
        //print_r($cart_p);
        // $cart_p = substr($cart_p,0,12);
        $cart_p = camel_case($cart_p);
//        print_r($cart_p);
        $catalog = new Catalog();
        $cart_prices = $catalog
            ->where('number', $cart_p)
            ->orwhere('artikul', $cart_p)
            ->get();
        $price = 'Под заказ';

//dd($cart_prices);
        foreach ($cart_prices as $cart_price) {
            // dd($cart_price);
            if ($cart_price->exists) {
                $price = $cart_price->price;
            }
        };

        return $price;
    }

    public static function UpdateProductCategori($category_name)
    {
        $val = explode('\\', $category_name);
        //   dd($val[1]);
        $count = count($val);

        if ($count > 1) {
            // если 1 не существует
            if (!$category1 = PrsoCategory::where('name', $val[1])->value('id')) {
                //     проверим есть ли 0
                if (!$category0 = PrsoCategory::where('name', $val[0])->value('id')) {
                    // если 0 не существует записываем корневую
                    $catnew = new PrsoCategory();
                    $catnew->name = $val[0];
                    $catnew->parent_id = null;
                    $catnew->save();
                    $categoryn = $catnew->id;
                    // записываем 1 новую с parent_id корневой
                    $catnew1 = new PrsoCategory();
                    $catnew1->name = $val[1];
                    $catnew1->depth = '1';
                    $catnew1->parent_id = $categoryn;
                    $catnew1->save();
                    $category = $catnew1->id;
                } else {
                    // если существует 0 записываем проверим соответствует ли id
                    $catnew2 = new PrsoCategory();
                    $catnew2->name = $val[1];
                    $catnew2->depth = '1';
                    $catnew2->parent_id = $category0;
                    $catnew2->save();
                    $category = $catnew2->id;
                }

            } else {

                $cat_parent_id = PrsoCategory::where('name', $val[1])->value('parent_id');
                $cat_parent_name = PrsoCategory::where('id', $cat_parent_id)->value('name');

                if ($cat_parent_name !== $val[0]) {
                    // если родительские не равны проверяем есть ли родительская с val[0]
                    if (!$category3 = PrsoCategory::where('name', $val[0])->value('id')) {
                        // если 0 не существует записываем корневую
                        $catnew = new PrsoCategory();
                        $catnew->name = $val[0];
                        $catnew->parent_id = null;
                        $catnew->save();
                        $categoryn = $catnew->id;
                        // записываем 1 новую с parent_id корневой
                        $catnew1 = new PrsoCategory();
                        $catnew1->name = $val[1];
                        $catnew1->depth = '1';
                        $catnew1->parent_id = $categoryn;
                        $catnew1->save();
                        $category = $catnew1->id;
                    } elseif (!$category4 = PrsoCategory::where('name', $val[1])->where('parent_id', $category3)->value('id')) {
                        // если существует 0 записываем проверим соответствует ли id
                        $catnew2 = new PrsoCategory();
                        $catnew2->name = $val[1];
                        $catnew2->depth = '1';
                        $catnew2->parent_id = $category3;
                        $catnew2->save();
                        $category = $catnew2->id;
                    } else {

                        $category = PrsoCategory::where('parent_id', $category3)->value('id');
                    }
                } else {

                    $category = $category1;
                }


            }
        } elseif (!$category = PrsoCategory::where('name', $val[0])->value('id')) {

            $catnew = new PrsoCategory();
            $catnew->name = $val[0];
            $catnew->parent_id = null;
            $catnew->save();
            $category = $catnew->id;
        }


        return $category;
        // dd($category);
    }


    public static function DetailInfo($market, $model, $compl, $opt, $code, $group, $graphic, $detail, $vin = null, $vdate = null, $siyopt = null)
    {
        $oTOY = SparesController::instance();

        $aPic = $oTOY->getToyPnc($market, $model, $compl, $opt, $code, $group, $graphic, $detail, $vin, $vdate, $siyopt);
//dd($aPic);
        $aDetInfo = SparesApiController::property($aPic, 'detInfo');
        // dd($aDetInfo);
        if (!$aDetInfo) die(("NULL REQUEST"));
///// При результате отдаем все в виде JSON строки
//       die( array($aDetInfo) );
//       // $aDetInfo = [$aDetInfo];


        // dd($aDetInfo);
        return $aDetInfo;
    }

    public static function DetailInfoNiss($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc)
    {
        $pnc = str_replace('+','_',$pnc);
//        dump($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc);
        $oNIS = SparesNissController::instance();
//        dd($oNIS);
        $aPic = $oNIS->getNisPnc($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc);
//        dd($aPic);
        $aDetInfo = $aPic->get('detInfo');
//         dd($aDetInfo);
        if (!$aDetInfo) die(("NULL REQUEST"));

        return $aDetInfo;
    }

    public static function callBackLink($detail, $callback = NULL, $name = "", $onlyLink = FALSE)
    {
        $name = (!$name) ? $detail : $name;
        if ($callback) {
            $_callBack = str_replace('{{DetailNumber}}', $detail, $callback);
            $r = "<a target=\"_blank\" href=\"$_callBack\" onclick=\"window.open(this.href, '_blank'); return false;\"><span class=\"c2c detailNumber\">$name</span></a>";
        } elseif (!$onlyLink) {
            $r = "<span class='c2c detailNumber'>$detail</span>";
        } else $r = FALSE;
        return $r;
    }

    public static function DetailOrder($order_id)
    {

        $orderitems = OrderItems::where('order_id', $order_id)->get();
//dd($orderitems);

        return $orderitems;

    }

    public static function CardItemPrice($cart_p)
    {
        // dd($cart_p);
        $catalog = new Catalog();

        $cart_prices = $catalog->where('number', $cart_p)->orWhere('artikul', $cart_p)->get();
        $price = 'Под заказ';

        foreach ($cart_prices as $cart_price) {
            // dd($cart_price);
            if ($cart_price->exists) {
                $price = $cart_price->price;
            }
        };

        return $price;
    }

    public static function CardItemOstatok($cart_p)
    {

        $catalog = new Catalog();
        $cart_prices = $catalog->where('number', '=', $cart_p)->get();
        $ostatok = 0;

        foreach ($cart_prices as $cart_price) {
            // dd($cart_price);
            if ($cart_price->exists) {
                $ostatok = $cart_price->ostatok;
            }
        };

        return $ostatok;
    }

    public static function DateModif($date)
    {
        $date = substr($date, 0, 4) . "-" . substr($date, 4, 2);

        return $date;
        dd($date);
    }

    public function repl($string){
        $string = str_replace('+','_',$string);
        return $string;
    }

    /**
     * Функция похожа на repl($string) , только используется на странице поиска в названиях моделей и т.д.
     * @param $str
     * @return mixed
     */
    public function replaceSS($str) {
        $str = str_replace('*','_',$str);
        $str = str_replace('-','_',$str);
        $str = str_replace(' ','_',$str);
        $str = str_replace('/','_',$str);
        return $str;
    }
}