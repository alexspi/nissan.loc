<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Excel;
use App\Models\PrsoProduct as Product;
use App\Models\PrsoCategories;
use App\Jobs\ParseModel;
use App\Http\Controllers\SparesNissController as SearchNum;
use Config;


class PrsoProductUpdateController extends SearchNum
{
    public function __construct()
    {
        parent::__construct();

    }

    public function download()
    {

        return view('vendor.backpack.import');
    }

    public function downloadExcel($type)
    {
        $data = Product::get()->toArray();
        return Excel::create('itsolutionstuff_example', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function importExcel()
    {
        $valuta = Config::get('settings.dollar');

        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->toObject();

            if (!empty($data) && $data->count()) {

                foreach ($data as $key => $value) {

                    $price = $value->prodazha;
                    $number = $value->number;
                    $number = str_replace('_неориг', '', $number);
                    $number = substr($number, 0, 14);
                    $number = str_replace('-', '_', $number);
                    $number = camel_case($number);
                    $number = strtoupper($number);

                    $insert[] = ['name' => $value->naimenovanie, 'number' => $number, 'price' => $price, 'ostatok' => $value->ostatok];

                }

                $dbprod = Product::all(['name', 'number', 'price', 'ostatok'])->toArray();

//                = $this->array_intersect_fixed($insert, $dbprod);

                $importupdate = $this->array_intersect_fixed($dbprod, $insert);

                $bdnullable = $this->array_intersect_fixed_null($dbprod, $importupdate);

                $importinsert = $this->array_intersect_fixed_null($insert, $importupdate);
                
                
                 foreach ($importupdate as $update){
                    
                    Product::where('number',$update['number'])->update($update);
                }

                if (count($bdnullable) !== 0){
                foreach ($bdnullable as $nulable){

                    Product::where('number',$nulable['number'])->update(['ostatok'=>null,'price'=> 0]);
                }
                }
                if (count($importinsert) !== 0){
                    Product::insert($importinsert);
                }

//                dump($dbprod, $importupdate, $bdnullable, 'xls', $importinsert, $insert);
//                dd();
//                $f = Product::updateOrCreate(['number' => $number], $insert);
//                dd();
            }

        }
        return back();
    }

    public function array_intersect_fixed($array1, $array2)
    {
        $result = [];

        foreach ($array1 as $val) {

            if (($key = array_search($val['number'], array_column($array2, 'number'))) !== false) {
                $result[] = $val;
                array_except($array2, $key);
            }
        }
        return $result;
    }

    public function array_intersect_fixed_null($array1, $array2)
    {
        $resultnull = [];
        foreach ($array1 as $val) {
            if (($key = array_search($val['number'], array_column($array2, 'number'))) !== false) {


            } else {
                $resultnull[] = $val;

            }
        }
        return $resultnull;
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
//    public function ParseCategory()
//    {
//
//        $prod = new Product();
//        $count = $prod->count();
//        $n = 1477;
//        dump($count,$n);
//        while ($n < $count) {
//
//          (new ParseModel($prod))->handle($n);
//
//            $n = $n + 1;
//        }
//        dump($count,$n);
//    }
//
//
//    public static function UpdateProductCategori($category_name)
//    {
//        $val = explode('\\', $category_name);
//        //   dd($val[1]);
//        $count = count($val);
//
//        if ($count > 1) {
//            // если 1 не существует
//            if (!$category1 = PrsoCategories::where('name', $val[1])->value('id')) {
//                //     проверим есть ли 0
//                if (!$category0 = PrsoCategories::where('name', $val[0])->value('id')) {
//                    // если 0 не существует записываем корневую
//                    $catnew = new PrsoCategories();
//                    $catnew->name = $val[0];
//                    $catnew->parent_id = null;
//                    $catnew->save();
//                    $categoryn = $catnew->id;
//                    // записываем 1 новую с parent_id корневой
//                    $catnew1 = new PrsoCategories();
//                    $catnew1->name = $val[1];
//                    $catnew1->depth = '1';
//                    $catnew1->parent_id = $categoryn;
//                    $catnew1->save();
//                    $category = $catnew1->id;
//                } else {
//                    // если существует 0 записываем проверим соответствует ли id
//                    $catnew2 = new PrsoCategories();
//                    $catnew2->name = $val[1];
//                    $catnew2->depth = '1';
//                    $catnew2->parent_id = $category0;
//                    $catnew2->save();
//                    $category = $catnew2->id;
//                }
//
//            } else {
//
//                $cat_parent_id = PrsoCategories::where('name', $val[1])->value('parent_id');
//                $cat_parent_name = PrsoCategories::where('id', $cat_parent_id)->value('name');
//
//                if ($cat_parent_name !== $val[0]) {
//                    // если родительские не равны проверяем есть ли родительская с val[0]
//                    if (!$category3 = PrsoCategories::where('name', $val[0])->value('id')) {
//                        // если 0 не существует записываем корневую
//                        $catnew = new PrsoCategories();
//                        $catnew->name = $val[0];
//                        $catnew->parent_id = null;
//                        $catnew->save();
//                        $categoryn = $catnew->id;
//                        // записываем 1 новую с parent_id корневой
//                        $catnew1 = new PrsoCategories();
//                        $catnew1->name = $val[1];
//                        $catnew1->depth = '1';
//                        $catnew1->parent_id = $categoryn;
//                        $catnew1->save();
//                        $category = $catnew1->id;
//                    } elseif (!$category4 = PrsoCategories::where('name', $val[1])->where('parent_id', $category3)->value('id')) {
//                        // если существует 0 записываем проверим соответствует ли id
//                        $catnew2 = new PrsoCategories();
//                        $catnew2->name = $val[1];
//                        $catnew2->depth = '1';
//                        $catnew2->parent_id = $category3;
//                        $catnew2->save();
//                        $category = $catnew2->id;
//                    } else {
//
//                        $category = PrsoCategories::where('parent_id', $category3)->value('id');
//                    }
//                } else {
//
//                    $category = $category1;
//                }
//
//
//            }
//        } elseif (!$category = PrsoCategories::where('name', $val[0])->value('id')) {
//
//            $catnew = new PrsoCategories();
//            $catnew->name = $val[0];
//            $catnew->parent_id = null;
//            $catnew->save();
//            $category = $catnew->id;
//        }
//
//
//        return $category;
//        // dd($category);
//    }

}
