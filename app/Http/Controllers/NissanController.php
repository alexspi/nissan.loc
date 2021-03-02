<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \KodiCMS\Assets\Contracts\MetaInterface;
use Illuminate\Support\Collection;
use Facades\App\Services\SparesNiss;
use App\Models\PrsoProduct as Catalog;

class NissanController extends SparesNissController
{

    public function __construct(MetaInterface $meta)
    {
        parent::__construct();
        $this->meta = $meta;

    }

    public function Index()
    {

        $this->meta->setTitle('Nissan209 Запчасти ниссан и инфинити в СПб');
        $this->meta->setMetaDescription('Оригинальные запчасти для Nissan в Санкт-Петербурге');
        $this->meta->setMetaKeywords('запчасти Ниссан, запчасти Инфинити');
        $this->meta->setMetaRobots('Index,follow');


        $url = "";
        return view('nissan.index', compact('url'));

    }

    public function Mark($mark)
    {


//        $oNIS = SparesNissController::instance();
        $NISMarkets = $this->getNisMarkets($mark);
        $url = "{$mark}";

        $this->meta->setTitle('Nissan209 Запчасти ' . $mark . ' в СПб');
        $this->meta->setMetaDescription('Оригинальные запчасти для ' . $mark . ' в Санкт-Петербурге');
        $this->meta->setMetaKeywords('запчасти ' . $mark . ', запчасти Инфинити');
        $this->meta->setMetaRobots('Index,follow');


        return view('nissan.mark', compact('NISMarkets', 'url'));

    }

    public function Market($mark, $market)
    {

/// Получаем спосок моделей по марке и рынку. Второй строкой останавливаемся при ошибках с сервера
        $NISModels = $this->getNisModels($mark, $market); ///$oNIS->e($TOYModels);

        if (($aErrors = $NISModels->get('errors'))) $this->error($aErrors, 404);

/// Получаем модели из общего объекта
        $aModels = $NISModels->get('aModels');
/// Базовая часть пути для перехода на следующий этап
        $url = "{$market}";

        return view('nissan.market', compact('aModels', 'url'));

    }

    public function Model($mark, $market, $model)
    {

/// Вернет объект: опции, расшифровка сокращений и "хлебные крошки"
        $NISModifs = $this->getNisModiff($market, $model); ///$oNIS->e($TOYOptions);

        $aBreads = $NISModifs->get('aBreads');
/// Останавливаемся при ошибках с сервера
        if (($aErrors = $NISModifs->get('errors'))) $this->error($aErrors, 404);

/// Получаем доступные опции из общего объекта, что вернул сервер
        $aModifs = $NISModifs->get('aModif');

        $shrts = [];

        foreach ($aModifs AS $k => $aModif) {
            foreach ($aModif as $k2 => $value) {
                if (!in_array($k2, ['compl', 'code', 'prod', 'other'])) {//исключаю постоянные поля, они не меняются

                    $aList[$k2] = [];
                    if ($k == 0) $shrts[$k2][] = $value;
                    elseif (($k > 0) && (!in_array($value, $shrts[$k2]))) {
                        $shrts[$k2][] = $value;
                    }
                } elseif ($k2 == 'other' && !empty($value)) {
                    if ($k == 0 && $k2 == 0) $shrts['other'] = [];//для сравнения in_array
                    foreach ($value as $item) {
                        if (!in_array($item, $shrts['other'])) $shrts['other'][] = $item;
                    }
                }
            }
        }

//        dd($aModifs,$aList);
        $_list = $NISModifs->get('info');
        if (!empty($_list)) {//бывает что список пуст...
            foreach ($_list as $k => $item) {
                foreach ($shrts as $k2 => $short) {
                    if (in_array($item->ABBRSTR, $short)) {
                        $aList[$k2][$item->ABBRSTR] = $item->DESCRSTR;
                    }
                }
            }
        }
/// Делаем ключи русскими
//        if(!empty($aList)) {
//            foreach ($aList as $k => $item) {
//                $aList[NIS::translate($k)] = $aList[$k];
//                unset($aList[$k]);
//            }
//        }
/// Формируем заголовок H1 для страницы, используя данные из "хлебных крошек"
        if (!empty($aBreads)) {
            $sMarket = $aBreads->models->name;
            $sModel = (!empty($aBreads->modifs)) ? $aBreads->modifs->name : $model;
            $sMark = ucfirst($mark);
            $h1 = "Запчасти для $sMark $sModel, список комплектаций ($sMarket)";
        }


/// Базовая часть пути для переходя на следующий этап
        $url = "{$model}";

        return view('nissan.model', compact('aModifs', 'url', 'aList', 'h1'));

    }

    public function groups($mark, $market, $model, $modif)
    {
        $aModInfo = $this->getNisModInfo($market, $model, $modif);

        $oGroups = $aModInfo->get('aModInfo');
        $aBreads = $aModInfo->get('aBreads');

        if (!empty($aBreads)) {
            $h1 = "Cписок групп модификации $modif для $mark " . $aBreads->modifs->name;
        }
        $srcImg = $aModInfo->get('Img');//mainImg

/// Базовая часть пути для переходя на следующий этап
        $url = "{$modif}";

        return view('nissan.groups', compact('oGroups', 'market', 'url', 'srcImg', 'h1'));
    }

    public function subgroups($mark, $market, $model, $modif, $group)
    {

        $aModInfos = $this->getNisModInfo($market, $model, $modif);
        $aModInfo = $this->getNisGroup($market, $model, $modif, $group);
        $oGroups = $aModInfos->get('aModInfo');
        $aGroups = $aModInfo->get('aGroup');
        $aBreads = $aModInfo->get('aBreads');
//dd($aModInfos,compact('oGroups','aGroups'));
        $srcImg = $aModInfo->get('Img');//картинка для всех кроме японии(у японцев много изображений может быть)

        $url = "{$group}";
        return view('nissan.subgroups', compact('oGroups', 'aGroups', 'market', 'url', 'srcImg'));

    }

    public function illustration(Request $request, $mark, $market, $model, $modif, $group, $figure)
    {
        $oNIS = SparesNissController::instance();

        $part = $request->part;
        $subfig = $request->subfig;
        $sec = $request->sec;
        $pic = $sec;

        $oIllustration = $this->getNisPic($market, $model, $modif, $group, $figure, $subfig, $sec);
//        dump($oIllustration);

        if (($errors = $oIllustration->get('errors'))) {
            if ($errors->msg == "_Nissan_Pic Empty_params") $msg = "По данному запросу нет применяемых запчастей";
            if ($errors->msg == "_Nissan_Pic Empty_Result") $msg = "По Вашему запросу ничего не найдено";
        } else {
            $msg = NULL;
            if ($oIllustration->count() !== null) {
                $aBreads = $oIllustration->get('aBreads');

                $aDetails = $oIllustration->get('details');
                $aTabs = $oIllustration->get('tabs');
                $aTCount = 0; ///Количество закладок ("табов")
                $subFlag = false; /// для определения какого типа будут закладки(у инфинити и остальных по разному)
                $aD = collect($aDetails)->collapse();

                $aD = $aD->unique('number');
//                dump($aTabs);

                $redirect = TRUE; /// Используется в случае если перешли с поиска
                /**встретил ситуацию когда секция одинаковая, отличается только subgroup */
//                dd($oIllustration,$aTabs,$part);
                //это значит что у нас не 1 фигура, как во многих случаях, а больше 2
                //и закладки по секции уже не определишь? поэтому поделил на подфигуры=>секции
                if (count($aTabs) > 1) $subFlag = true;
                foreach ($aTabs as $key => $tab1) {
                    foreach ($tab1 as $tab) {
//  dump($tab);
                        $aTCount++;
                        if (empty($subfigure)) $subfigure = $tab->figure;
                        if (empty($mdldir)) $mdldir = $tab->MDLDIR;
                        if ($tab->secno == $sec && $aTCount > 1) $redirect = FALSE; /// Если табы совпадут и это не первый таб - редирект уже был
                    }
                }
                if (!empty($part) && $aTCount > 1) {
                    $url = '/podbor/' . $mark . '/' . $market . '/' . $model . '/' . $modif . '/' . $group . '/' . $figure;
//                    $url = route('nissan.market.model.groups.illustration', [$mark, $market, $model, $modif, $group, $figure, $subfig = NULL, $sec = NULL]);
                    foreach ($aDetails as $key => $aDs) {
                        foreach ($aDs as $aDetail) {
                            if ($aDetail->number == $part) {
                                $redirect = false;
                                continue;
                            }
                        }

                        if ($redirect) {
                            if ($aTCount == 2) {
                                $tabCnt = 0;
                                foreach ($aTabs as $tab1) {
                                    foreach ($tab1 as $tab) {
                                        $tabCnt++;
                                        if ($tabCnt == 2) $endRedir = '?subfig=' . $tab->figure . '&sec=' . $tab->secno;
//                                        dd($endRedir);
                                    }
                                }
                                $url .= $endRedir . '&part=' . $part;
                            } else {
                                $answ = $this->getNisPicRedirect($market, $mdldir, $subfigure, $part);


                                if (!empty($answ)) {
                                    $doNotRed = TRUE;
                                    $url .= '?subfig=' . $subfigure . '&sec=' . $answ->get('sec') . '&part=' . $part;
//                                    dd($url);
                                }
                            }
//                            dump($url);
                            if (empty($doNotRed)) return redirect($url);
                        }
                    }
                }


                /// Получаем данные для построение иллюстрации из общего объекта, что вернул сервер:
                $imgInfo = $oIllustration->get('imgInfo');    /// Объект:
//                dump($imgInfo);
                $iSID = $imgInfo->iSID;          /// Ключ, нужен для построение картинки
                $imgUrl = $imgInfo->url;           /// Адрес иллюстрации на сервере
                $width = $imgInfo->width;         /// Ширина изображения
                $height = $imgInfo->height;        /// Высота изображения
                $attrs = $imgInfo->attrs;         /// Те же данные одним атрибутом
                $prc = $imgInfo->percent / 100; /// Ограничения показов с одного агента на IP( показы/100 < 1 = показывать)
//                $limit = SparesApiController::property($imgInfo, 'limit');         /// Ваше число ограничений для отображения пользователю, у которого сработало ограничение
//                $abr = $this->getNisPicImg($iSID);
                /// Корневой элемент для зума
                $rootZoom = "imageLayout";

                /// действие для следующего/предыдущего изображения

//                dump($aD);

                $fulldetail = [];

                foreach ($aD as $aDetail) {


                    $InfoDetails = $this->DetailInfoNiss($market, $model, $modif, $group, $figure, $subfig, $aDetail->secno, $aDetail->number);

                    if ($InfoDetails !== null && $aDetail->type == '0') {
                        foreach ($InfoDetails as $infoDetail) {
                            $solodetail = [];


                            $solodetail = array_add($solodetail, 'anum', $aDetail->number);
                            $solodetail = array_add($solodetail, 'desc', $aDetail->desc_en);
                            $solodetail = array_add($solodetail, 'number', $infoDetail->serialNumber);
                            $solodetail = array_add($solodetail, 'price', $this->CatalogItemPrice($infoDetail->serialNumber));

                            $fulldetail[] = $solodetail;
                        }
                    } elseif ($aDetail->type == '1') {
                        $solodetail = [];
                        $solodetail = array_add($solodetail, 'anum', '****');
                        $solodetail = array_add($solodetail, 'desc', $aDetail->desc_en);
                        $solodetail = array_add($solodetail, 'number', $aDetail->number);
                        $solodetail = array_add($solodetail, 'price', $this->CatalogItemPrice($aDetail->number));

                        $fulldetail[] = $solodetail;
                    } elseif ($aDetail->type == '2') {
                        $solodetail = [];
                        $solodetail = array_add($solodetail, 'anum', $aDetail->number);
                        $solodetail = array_add($solodetail, 'desc', $aDetail->desc_en);
                        $solodetail = array_add($solodetail, 'number', '');
                        $solodetail = array_add($solodetail, 'price', '');

                        $fulldetail[] = $solodetail;

                    }
                }
                $fulldetails = $this->unique_multidim_array($fulldetail, 'number');

//                dump($fulldetails);
                /// Адрес для получения информации
                $nextUrl = route('nissan.market.model.groups.illustration', [$mark, $market, $model, $modif, $group, $figure, $subfig = NULL, $sec = NULL]);
                /// Адрес для закладок
                $nextSecUrl = route('nissan.market.model.groups.illustration', [$mark, $market, $model, $modif, $group, $figure, $subfig = NULL]);
                /// Адрес для перехода к другому изображению
                $secUrl = route('nissan.market.model.groups.illustration', [$mark, $market, $model, $modif, $group, $figure]);

                $markName = urlencode($mark);
                $modelName = urlencode($aBreads->modifs->name);

                return view('nissan.illustration4', compact('fulldetails', 'aDetails', 'aD', 'part', 'oNIS', 'prc', 'subfig', 'pic', 'subFlag', 'aTCount', 'mark', 'market', 'model', 'modif', 'group', 'figure', 'aTabs', 'nextUrl', 'iSID', 'imgUrl', 'width', 'height', 'attrs', 'rootZoom', 'imgInfo', 'nextSecUrl', 'secUrl', 'msg'));

            } else {
                $msg = "По Вашему запросу ничего не найдено";
            };

        }

    }

    /**
     * @return array
     */
    public function searchVin(Request $request)
    {

//        $this->validate($request, [
//            'vin' => 'required|alpha_num|digits_between:min=9,max=17',
//
//        ]);

        $oNIS = SparesNissController::instance();
        $vin = $request->vin;
        $mark = $request->mark;

        $searchRezult = $this->searchNisVIN($vin, $mark);
//        dump($searchRezult);
        if (($searchRezult->get('errors') != null)) {
            if ($searchRezult->get('errors') == "_Nissan_Search_VIN VIN_Empty") $msg = "Не указан VIN";
            if ($searchRezult->get('errors') == "_Nissan_Search_VIN Empty_Response") $msg = "По Вашему запросу ничего не найдено";
        } else {
            $aRezult = $searchRezult->get('models');
//            dd($aRezult);
            if (count($aRezult) == 1) {
                /// Если сервер вернул одну модель, нет смысла показывать одну строчку, сразу переходим в модель
                $url = '/podbor/' . $mark . '/' . $aRezult[0]->market . '/' . $aRezult[0]->modelCode . '/' . $aRezult[0]->compl;
                return redirect($url);
            };


            $aCurrent = current($aRezult);
            $aFields = [];
            foreach ($aRezult as $km => $rez) {
                $i = 0;
                foreach ($rez as $k => $v) {
                    $notIn = !in_array($k, ['market', 'marketRU', 'modelName', 'modelCode', 'compl', 'dir', 'prod', 'other']);
                    $notInList = !in_array(SparesNissController::translate(strtolower(trim($k))), $aFields);
                    if ($notIn) {
                        if ($notInList) {
                            if (!empty($aFields[$i])) $aFields[$i] .= ' / ' . NIS::translate(strtolower($k));
                            else $aFields[] = SparesNissController::translate(strtolower($k));
                        }
                        $i++;
                    }
                }
            }
            $shrts = [];
            if (!empty($aRezult)) {
                foreach ($aRezult AS $k => $aRezrow) {
                    foreach ($aRezrow as $k2 => $value) {
                        if (!in_array($k2, ['market', 'marketRU', 'modelName', 'modelCode', 'compl', 'dir', 'prod', 'other'])) {//исключаю постоянные поля, они не меняются

                            $aList[strtolower($k2)] = [];
                            if ($k == 0) $shrts[strtolower($k2)][] = $value;
                            elseif (!array_key_exists(strtolower($k2), $shrts) || ($k > 0 && (!in_array($value, $shrts[strtolower($k2)])))) {
                                $shrts[strtolower($k2)][] = $value;
                            }
                        } elseif (strtolower($k2) == 'other' && !empty($value)) {
                            if ($k == 0 && $k2 == 0) $shrts['other'] = [];//для сравнения in_array
                            $value = explode(' ', $value);
                            foreach ($value as $item) {
                                if (!in_array($item, $shrts['other'])) $shrts['other'][] = $item;
                            }
                        }
                    }
                }
            }
            $aList = [];

            $_list = SparesApiController::property($searchRezult, 'info', []);
            if (!empty($_list))//бывает что список пуст...
                foreach ($_list as $k => $item) {
                    foreach ($shrts as $k2 => $short) {
                        if (in_array($item->ABBRSTR, $short)) {
                            $aList[$k2][$item->ABBRSTR] = $item->DESCRSTR;
                        }
                    }
                }
            //делаю ключи русскими для вьюшки, т.к. во вьюхе только вывод, без какой либо логики
            foreach ($aFields as $field) $newList[$field] = [];
            $newList['Другое'] = [];
            if (!empty($aList))
                foreach ($newList as $key2 => $item2) {
                    foreach ($aList as $k => $item) {
                        if (!in_array($newList[$key2], $item) && ($key2 == SparesNissController::translate($k) || stripos($key2, SparesNissController::translate($k)))) {
                            $newList[$key2] = $item;
                        }
                    }
                }
            $aList = $newList;

            return view('nissan.vinandframe', compact('aRezult', 'aList', 'aFields', 'mark'));
        }


    }

    public function searchFrame(Request $request)
    {

//        $this->validate($request, [
//            'vin' => 'required|alpha_num|digits_between:min=9,max=17',
//
//        ]);

        $oNIS = SparesNissController::instance();
        $frame = $request->frame;
        $serial = $request->serial;

        $mark = $request->mark;

        $searchRezult = $this->searchNisFrame($frame, $mark, $serial, 'y');

//        dd($frame,$serial,$mark,$searchRezult);

        if (($errors = SparesApiController::property($searchRezult, 'errors'))) {
            if ($errors->msg == "_Nissan_Search_VIN VIN_Empty") $msg = "Не указан VIN";
            if ($errors->msg == "_Nissan_Search_VIN Empty_Response") $msg = "По Вашему запросу ничего не найдено";
        } else {
            $aRezult = SparesApiController::property($searchRezult, 'models', []);
//            dd($aRezult);
            $count = count((array)$aRezult);
            /// Если сервер вернул одну модель, нет смысла показывать одну строчку, сразу переходим в модель
            $url = '/podbor/' . $mark . '/' . $aRezult[0]->market . '/' . $aRezult[0]->modelCode . '/' . $aRezult[0]->compl;

//            $url = '/nissan/groups.php?market='.$aRezult[0]->market.'&model='.$aRezult[0]->modelCode.'&modif='.$aRezult[0]->compl;
//            if( $count == 1 ) return redirect($url);

            $aCurrent = current($aRezult);
            $aFields = [];
            foreach ($aRezult as $km => $rez) {
                $i = 0;
                foreach ($rez as $k => $v) {
                    $notIn = !in_array($k, ['market', 'marketRU', 'modelName', 'modelCode', 'compl', 'dir', 'prod', 'other']);
                    $notInList = !in_array(SparesNissController::translate(strtolower(trim($k))), $aFields);
                    if ($notIn) {
                        if ($notInList) {
                            if (!empty($aFields[$i])) $aFields[$i] .= ' / ' . NIS::translate(strtolower($k));
                            else $aFields[] = SparesNissController::translate(strtolower($k));
                        }
                        $i++;
                    }
                }
            }
            $shrts = [];
            if (!empty($aRezult)) {
                foreach ($aRezult AS $k => $aRezrow) {
                    foreach ($aRezrow as $k2 => $value) {
                        if (!in_array($k2, ['market', 'marketRU', 'modelName', 'modelCode', 'compl', 'dir', 'prod', 'other'])) {//исключаю постоянные поля, они не меняются

                            $aList[strtolower($k2)] = [];
                            if ($k == 0) $shrts[strtolower($k2)][] = $value;
                            elseif (!array_key_exists(strtolower($k2), $shrts) || ($k > 0 && (!in_array($value, $shrts[strtolower($k2)])))) {
                                $shrts[strtolower($k2)][] = $value;
                            }
                        } elseif (strtolower($k2) == 'other' && !empty($value)) {
                            if ($k == 0 && $k2 == 0) $shrts['other'] = [];//для сравнения in_array
                            $value = explode(' ', $value);
                            foreach ($value as $item) {
                                if (!in_array($item, $shrts['other'])) $shrts['other'][] = $item;
                            }
                        }
                    }
                }
            }
            $aList = [];

            $_list = SparesApiController::property($searchRezult, 'info', []);
            if (!empty($_list))//бывает что список пуст...
                foreach ($_list as $k => $item) {
                    foreach ($shrts as $k2 => $short) {
                        if (in_array($item->ABBRSTR, $short)) {
                            $aList[$k2][$item->ABBRSTR] = $item->DESCRSTR;
                        }
                    }
                }
            //делаю ключи русскими для вьюшки, т.к. во вьюхе только вывод, без какой либо логики
            foreach ($aFields as $field) $newList[$field] = [];
            $newList['Другое'] = [];
            if (!empty($aList))
                foreach ($newList as $key2 => $item2) {
                    foreach ($aList as $k => $item) {
                        if (!in_array($newList[$key2], $item) && ($key2 == SparesNissController::translate($k) || stripos($key2, SparesNissController::translate($k)))) {
                            $newList[$key2] = $item;
                        }
                    }
                }
            $aList = $newList;

            return view('nissan.vinandframe', compact('aRezult', 'aList', 'aFields', 'mark'));
        }


    }

    public function searchNumber(Request $request)
    {

        $number = $request->number;
//
        $allMarkets[] = $this->getNisMarkets('');
        $Result = [];
//        dump($allMarkets);
        foreach ($allMarkets as $key => $market) {

//            dump($market);
            $markets[] = $key;

            foreach ($market as $k => $n) {

                if ($k !== 'jp') {
                    $searchRezult = $this->searchNISNumber($number, $k);

                    if (!$searchRezult->get('errors')) {
                        $aTree = $searchRezult->get('models'); //$this->e($aRezult);
                        $about = $searchRezult->get('about'); //$this->e($aRezult);
                        $msg = null;

                        foreach ($aTree as $mod => $item) {

                            foreach ($item as $ks => $modif) {


                                if ($ks == 'name') {
                                    $forUrl = $modif;
                                } else {
                                    foreach ($modif as $km => $part) {
                                        if ($km !== 'date') {
                                            $res = [];
                                            $urlM = '/podbor/' . $about->mark . '/' . $k . '/' . $forUrl . '/' . $mod . '/' . $part->group . '/' . $part->figure . '?part=' . urlencode($part->partcode);
                                            $res = array_add($res, 'market', $n);
                                            $res = array_add($res, 'mark', $about->mark);
                                            $res = array_add($res, 'model', $mod);
                                            $res = array_add($res, 'date', $modif->date);
                                            $res = array_add($res, 'partname', $part->partname);
                                            $res = array_add($res, 'url', $urlM);

                                            $Result[] = $res;
//
                                        }
                                    }

                                }
                            }
                        }


                    }

                }
            }

        }
//        dump($Result);

        if (count($Result) == 0) {
            $msg = "По Вашему запросу ничего не найдено";
        } else {
            $msg = null;
        }

        return view('nissan.searchnumber', compact('Result', 'msg'));
    }


    public function set(Request $request)
    {
        $cookieName = $request->input('cookie_name');
        $cookieVal = $request->input('cookie_val');

//        Cookie :: make( $cookieName , $cookieVal  );
//        $response =  Response :: make ();
//        return  Response :: make ( 'test' );
        return response()->json(['previousCookieValue' => Cookie::get('serNumbers')])->withCookie(cookie($cookieName, $cookieVal));
    }

    public
    function events()
    {
        return response()->json([
            'cookieValue' => Cookie::get('serNumbers'),
        ]);
    }

    /**
     * @return mixed
     */
    public
    function getmodel()
    {
        $r = file_get_contents($url);
    }


    public static function DetailInfoNiss($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc)
    {
        $pnc = str_replace('+', '_', $pnc);
//        dump($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc);
        $oNIS = SparesNissController::instance();
//        dd($oNIS);
        $aPic = $oNIS->getNisPnc($market, $model, $modif, $group, $figure, $subfig, $sec, $pnc);
//        dump($aPic);
        $aDetInfo = $aPic->get('detInfo');
//        dump($aDetInfo);
//        if (!$aDetInfo) die(("NULL REQUEST"));

        return $aDetInfo;
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


    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
