<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.01.2018
 * Time: 16:52
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchPegasusApiController extends RequestPegasusApiController
{

    public function index()
    {


        return view('frontEnd.pegasus.search.index');
    }


    public function result(Request $request)
    {
        $articleSearchNo = $request->articleSearchNo;
        $numberType = $request->numberType;

        $function = 'getArticleDirectSearchAllNumbersWithState';

        $params = [
            'articleCountry'   => 'RU',
            'articleNumber'    => $articleSearchNo,
            'brandId'          => Null,
            'genericArticleId' => Null,
            'lang'             => 'ru',
            'numberType'       => $numberType,
            'provider'         => 120,
            'searchExact'      => true,
            'sortType'         => 2,

        ];
        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

//          dd($jsonRequest);
        $data = $jsonRequest['data']['array'];
//        dd($data);

        foreach ($data as $id) {

            $carid[] = $id['articleId'];
        }
        dump($carid);
        if (count($carid) <= 25) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $info = $this->resultM($object0);
        } elseif (count($carid) > 25 & count($carid) <= 50) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $object1 = (object)['array' => array_slice($carid, 25, 25)];

            $info0 = $this->resultM($object0);
            $info1 = $this->resultM($object1);
            $info = array_merge($info0, $info1);
        } elseif (count($carid) > 50 & count($carid) <= 75) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $object1 = (object)['array' => array_slice($carid, 25, 25)];
            $object2 = (object)['array' => array_slice($carid, 50, 25)];
            $info0 = $this->resultM($object0);
            $info1 = $this->resultM($object1);
            $info2 = $this->resultM($object2);
            $info = array_merge($info0, $info1, $info2);
        }
//
//
dump($info);

        return view('frontEnd.pegasus.search.result')->with('results', $info);
    }


    public function resultM($articleId)
    {

        $function = 'getDirectArticlesByIds6';

        $params = [
            'articleCountry'    => 'RU',
            'articleId'         => json_encode($articleId),
            'basicData'         => true,
            'documents'         => true,
            'eanNumbers'        => true,
            'lang'              => 'ru',
            'oeNumbers'         => true,
            'provider'          => 120,
            'replacedByNumbers' => 120,
            'replacedNumbers'   => true,
            'thumbnails'        => true,
            'usageNumbers'      => true,

        ];
        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

        //  dd($jsonRequest);
        $data = $jsonRequest['data']['array'];


        return $data;
    }


}