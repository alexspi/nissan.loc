<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.01.2018
 * Time: 18:16
 */

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\ModelsCars;
use App\Models\Brands;
use Cache;

class PegasusApiController extends RequestPegasusApiController
{


    public function index()
    {

        return view('pegasus.index');
    }

    public function models($manuId)
    {

        $data = ModelsCars::select()->where('manuId', $manuId)->where('status', 1)->get();
//        dd($data);
        return view('pegasus.model')->with(['models' => $data, 'mark' => $manuId]);
    }

    public function modifs($manuId, $modId)
    {
        $function = 'getVehicleIdsByCriteria';

        $params = [
            'countriesCarSelection' => 'RU',
            'countryCode'           => 'RU',
            'carType'               => 'P',
            'manuId'                => $manuId,
            'modId'                 => $modId,
            'lang'                  => 'ru',
            'provider'              => config('apiconnect.provider'),
        ];
        $response = $this->request($function, $params);
//dump(config('apiconnect.provider'));
        $jsonRequest = json_decode($response, true);
//        dump($jsonRequest['data']['array']);
        $data = $jsonRequest['data']['array'];

        foreach ($data as $id) {
            Cache::tags([$manuId, $modId])->forever($id['carId'], $id['carName']);
            $carid[] = $id['carId'];
        }

        if (count($carid) <= 25) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $info = $this->carIdmodifs($object0);
        } elseif (count($carid) > 25 & count($carid) <= 50) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $object1 = (object)['array' => array_slice($carid, 25, 25)];

            $info0 = $this->carIdmodifs($object0);
            $info1 = $this->carIdmodifs($object1);
            $info = array_merge($info0, $info1);
        } elseif (count($carid) > 50 & count($carid) <= 75) {
            $object0 = (object)['array' => array_slice($carid, 0, 25)];
            $object1 = (object)['array' => array_slice($carid, 25, 25)];
            $object2 = (object)['array' => array_slice($carid, 50, 25)];
            $info0 = $this->carIdmodifs($object0);
            $info1 = $this->carIdmodifs($object1);
            $info2 = $this->carIdmodifs($object2);
            $info = array_merge($info0, $info1, $info2);
        }


        return view('pegasus.modifs')->with(['modifs' => $info, 'mark' => $manuId, 'model' => $modId]);
    }

    public function carIdmodifs($info)
    {
        $function = 'getVehicleByIds3';

        $params = [
            'articleCountry'        => 'RU',
            'carIds'                => json_encode($info),
            'countriesCarSelection' => 'RU',
            'lang'                  => 'ru',
            'provider'              => config('apiconnect.provider'),
        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
//        dump($jsonRequest);
        $data = $jsonRequest['data']['array'];

        foreach ($data as $d) {

            $vehicleDetails[] = $d['vehicleDetails'];
        }
        return $vehicleDetails;
    }

    public function getMainTreeSpares($manuId, $modId, $carId)
    {
        $function = 'getShortCuts2';

        $params = [
            'articleCountry'    => 'RU',
//            'childNodes'        => false,
            'linked'            => true,
            'lang'              => 'ru',
            'linkingTargetId'   => $carId,
            'linkingTargetType' => 'P',
            'provider'          => config('apiconnect.provider'),

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
        $data = $jsonRequest['data']['array'];
        foreach ($data as $id) {
            Cache::tags([$manuId, $modId, $carId])->forever($id['shortCutId'], $id['shortCutName']);
        }
//dump($data);

        return view('pegasus.tree')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $data]);
    }

    public function getSubTreeSpares($manuId, $modId, $carId, $mtree)
    {
        $function = 'getChildNodesAllLinkingTarget2';

        $params = [
            'articleCountry'    => 'RU',
            'childNodes'        => false,
            'linked'            => true,
            'lang'              => 'ru',
            'linkingTargetId'   => $carId,
//            'parentNodeId'      => $mtree,
            'linkingTargetType' => 'P',
            'provider'          => config('apiconnect.provider'),
            'shortCutId'        => $mtree,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
//        dump($jsonRequest);
        $data = $jsonRequest['data']['array'];

//        dump($data);
        $sortArray = [];

        foreach ($data as $person) {
            Cache::tags([$manuId, $modId, $carId, $mtree])->forever($person['assemblyGroupNodeId'], $person['assemblyGroupName']);
            foreach ($person as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = [];
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "hasChilds"; //change this to whatever key you want from the array

        array_multisort($sortArray[$orderby], SORT_DESC, $data);

        foreach ($data as $key => $val) {
            $datanotnul = $this->notNullSpares($carId, $val['assemblyGroupNodeId']);


            if ($datanotnul == false & $val['hasChilds'] == false) {
                unset($data[$key]);
            }

            if ($val['assemblyGroupNodeId'] == 103159 || $val['assemblyGroupNodeId'] == 101830 || $val['assemblyGroupNodeId'] == 104406 || $val['assemblyGroupNodeId'] == 101837) {
                unset($data[$key]);
            }
        }

        return view('pegasus.subtree')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $mtree, 'subtree' => $data]);
    }

    public function getSubTreeSpares1($manuId, $modId, $carId, $mtree, $parentNodeId)
    {
        $function = 'getChildNodesAllLinkingTarget2';

        $params = [
            'articleCountry'    => 'RU',
            'childNodes'        => false,
            'linked'            => true,
            'lang'              => 'ru',
            'linkingTargetId'   => $carId,
            'linkingTargetType' => 'P',
            'parentNodeId'      => $parentNodeId,
            'provider'          => config('apiconnect.provider'),
//            'shortCutId'        => $mtree,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
        $data = $jsonRequest['data']['array'];

//        dump($data);
        $sortArray = [];

        foreach ($data as $person) {

            foreach ($person as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = [];
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "hasChilds"; //change this to whatever key you want from the array

        array_multisort($sortArray[$orderby], SORT_DESC, $data);
//dump($data);
        foreach ($data as $key => $val) {
            $datanotnul = $this->notNullSpares($carId, $val['assemblyGroupNodeId']);
//dd($val);
//            dump($datanotnul);

//            if ($val['hasChilds'] == true) {
//
//                unset($data[$key]);
//            }
            if ($datanotnul === false & $val['hasChilds'] == false) {
                unset($data[$key]);
            }

            if ($val['assemblyGroupNodeId'] == 103159 || $val['assemblyGroupNodeId'] == 101830 || $val['assemblyGroupNodeId'] == 104406 || $val['assemblyGroupNodeId'] == 101837) {
                unset($data[$key]);
            }
        }
        foreach ($data as $person) {
            Cache::tags([$manuId, $modId, $carId, $mtree, $parentNodeId])->forever($person['assemblyGroupNodeId'], $person['assemblyGroupName']);
        }

//        Cache::put('breadlvl', 1, 60);
        return view('pegasus.subtree1')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $mtree, 'parentNodeId' => $parentNodeId, 'subtree' => $data]);
    }

    public function getSubTreeSpares2($manuId, $modId, $carId, $mtree, $parentNodeId, $parentNodeId1)
    {
        $function = 'getChildNodesAllLinkingTarget2';

        $params = [
            'articleCountry'    => 'RU',
            'childNodes'        => true,
            'linked'            => true,
            'lang'              => 'ru',
            'linkingTargetId'   => $carId,
            'linkingTargetType' => 'P',
            'parentNodeId'      => $parentNodeId1,
            'provider'          => config('apiconnect.provider'),
//            'shortCutId' => $mtree,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
        $data = $jsonRequest['data']['array'];


        $sortArray = [];

        foreach ($data as $person) {
            foreach ($person as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = [];
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "hasChilds"; //change this to whatever key you want from the array

        array_multisort($sortArray[$orderby], SORT_DESC, $data);

//       dump($data);


        foreach ($data as $key => $val) {
            $datanotnul = $this->notNullSpares($carId, $val['assemblyGroupNodeId']);

            if ($val['hasChilds'] == true) {

                unset($data[$key]);
            }

            if ($datanotnul == false & $val['hasChilds'] == false) {
                unset($data[$key]);
            }

        }
//        dump($manuId, $modId, $carId, $mtree, $parentNodeId,$parentNodeId1);
        foreach ($data as $person) {
            Cache::tags([$manuId, $modId, $carId, $mtree, $parentNodeId, $parentNodeId1])->forever($person['assemblyGroupNodeId'], $person['assemblyGroupName']);
        }
//        Cache::put('breadlvl', 2, 60);
        return view('pegasus.subtree2')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $mtree, 'parentNodeId' => $parentNodeId, 'parentNodeId1' => $parentNodeId1, 'subtree' => $data]);
    }

    public function getSubTreeSpares3($manuId, $modId, $carId, $mtree, $parentNodeId, $parentNodeId1, $parentNodeId2)
    {
        $function = 'getChildNodesAllLinkingTarget2';

        $params = [
            'articleCountry'    => 'RU',
            'childNodes'        => true,
            'linked'            => true,
            'lang'              => 'ru',
            'linkingTargetId'   => $carId,
            'linkingTargetType' => 'P',
            'parentNodeId'      => $parentNodeId2,
            'provider'          => config('apiconnect.provider'),
//            'shortCutId' => $mtree,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
        $data = $jsonRequest['data']['array'];


        $sortArray = [];

        foreach ($data as $person) {
            foreach ($person as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = [];
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "hasChilds"; //change this to whatever key you want from the array

        array_multisort($sortArray[$orderby], SORT_DESC, $data);

        foreach ($data as $key => $val) {
            $datanotnul = $this->notNullSpares($carId, $val['assemblyGroupNodeId']);
//dd($val);
            if ($datanotnul == false & $val['hasChilds'] == false) {
                unset($data[$key]);
            }

            if ($val['assemblyGroupNodeId'] == 103159 || $val['assemblyGroupNodeId'] == 101830 || $val['assemblyGroupNodeId'] == 104406 || $val['assemblyGroupNodeId'] == 101837) {
                unset($data[$key]);
            }
        }

        return view('frontEnd.pegasus.subtree3')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $mtree, 'parentNodeId' => $parentNodeId, 'subtree' => $data]);
    }


    public function getSparesList($manuId, $modId, $carId, $mtree, $parentNodeId, $GroupNodeId)
    {
        $function = 'getArticleIdsWithState';
        $brands = Brands::select('brandId')->where('status', 1)->get();

        foreach ($brands as $brand) $array[] = $brand->brandId;


        $object = (object)['array' => $array];

//        dump($object);
        $params = [
            'articleCountry'      => 'RU',
            'assemblyGroupNodeId' => $GroupNodeId,
            'brandNo'             => json_encode($object),
            'lang'                => 'ru',
            'linkingTargetId'     => $carId,
            'linkingTargetType'   => 'P',
            'provider'            => config('apiconnect.provider'),
            'sort'                => 1,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

        $data = $jsonRequest['data']['array'];

        $articleIdPairs =[];
        $list = $this->unique_multidim_array($data, 'brandNo');
//dump($list);
        foreach ($list as $d) {
//dump('L',$d);

                $articleIdPairs[] = ['articleId' => $d['articleId'], 'articleLinkId' => $d['articleLinkId']];
                $mainList[] = $d;

        }
	//	dump($articleIdPairs);
		$provniss = $this->getSparesListInfo($manuId, $modId, $carId, (object)['array' => $articleIdPairs]);
//        dump($mainList);
        foreach ($mainList as $person) {
            Cache::tags(['sp', $manuId, $modId, $carId, $mtree, $parentNodeId, $GroupNodeId])->put($person['brandName'], $person['brandName'],600);
        }

        return view('pegasus.spares')->with(['mark' => $manuId, 'model' => $modId, 'modifs' => $carId, 'maintree' => $mtree, 'parentNodeId' => $parentNodeId, 'GroupNodeId' => $GroupNodeId, 'Spares' => $mainList]);
    }

    public function getSparesList1($manuId, $modId, $carId, $mtree, $parentNodeId, $SubGroupNodeId, $GroupNodeId)
    {
        $function = 'getArticleIdsWithState';
        $brands = Brands::select('brandId')->where('status', 1)->get();

        foreach ($brands as $brand) $array[] = $brand->brandId;


        $object = (object)['array' => $array];

//        dump($object);
        $params = [
            'articleCountry'      => 'RU',
            'assemblyGroupNodeId' => $GroupNodeId,
            'brandNo'             => json_encode($object),
            'lang'                => 'ru',
            'linkingTargetId'     => $carId,
            'linkingTargetType'   => 'P',
            'provider'            => config('apiconnect.provider'),
            'sort'                => 1,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

        $data = $jsonRequest['data']['array'];

        $articleIdPairs =[];
        $list = $this->unique_multidim_array($data, 'brandNo');
//dump($list);
        foreach ($list as $d) {
//dump('L',$d);

                $articleIdPairs[] = ['articleId' => $d['articleId'], 'articleLinkId' => $d['articleLinkId']];
                $mainList[] = $d;

        }
	//	dump($articleIdPairs);
		$provniss = $this->getSparesListInfo($manuId, $modId, $carId, (object)['array' => $articleIdPairs]);
//        dump($mainList);
        foreach ($mainList as $person) {
            Cache::tags(['sp', $manuId, $modId, $carId, $mtree, $parentNodeId, $SubGroupNodeId, $GroupNodeId])->put($person['brandName'], $person['brandName'],600);
        }

        return view('pegasus.spares1')->with([
            'mark' => $manuId,
            'model' => $modId,
            'modifs' => $carId,
            'maintree' => $mtree,
            'parentNodeId' => $parentNodeId,
            'SubGroupNodeId' => $SubGroupNodeId,
            'GroupNodeId' => $GroupNodeId,
            'Spares' => $mainList]);
    }


    public function getSparesListInfoFull($manuId, $modId, $carId, $mtree, $parentNodeId, $GroupNodeId, $articleId, $articleLinkId, $brandName)
    {
        $articleIdPairs =[];
        $function = 'getAssignedArticlesByIds6';
        $articleIdPairs[] =  ['articleId' => $articleId, 'articleLinkId' => $articleLinkId];
	//	dump((object)['array' => $articleIdPairs]);
		
		$rrr = (object)['array' => $articleIdPairs];
        $params = [
            'articleCountry'       => 'RU',
            'articleIdPairs'       => json_encode($rrr),
            'attributs'            => true,
            'basicData'            => true,
            'documents'            => true,
            'eanNumbers'           => true,
            'info'                 => true,
            'lang'                 => 'ru',
            'linkingTargetId'      => $carId,
            'linkingTargetType'    => 'P',
            'mainArticles'         => true,
            'manuId'               => $manuId,
            'modId'                => $modId,
            'normalAustauschPrice' => false,
            'oeNumbers'            => true,
            'prices'               => false,
            'provider'             => config('apiconnect.provider'),
            'replacedByNumbers'    => true,
            'replacedNumbers'      => true,
            'thumbnails'           => true,
            'usageNumbers'         => true,

        ];
//dump($params);
        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

//        dump($jsonRequest);
        $data = $jsonRequest['data']['array']['0'];

//        dump($data);
        if ($data['articleAttributes'] == "") {
            $articleAttributes = NULL;
        } else {
            $articleAttributes = $data['articleAttributes']['array'];
        }


        if ($data['articleDocuments'] == "") {
            $articleDocuments = NULL;
        } else {
            $articleDocuments = $data['articleDocuments']['array'];
        }

//        dump($articleDocuments);
        if ($data['assignedArticle'] == "") {
            $assignedArticle = NULL;
        } else {
            $assignedArticle = $data['assignedArticle'];
        }
        if ($data['eanNumber'] == "") {
            $eanNumber = NULL;
        } else {
            $eanNumber = $data['eanNumber']['array']['0'];
        }

        if ($data['oenNumbers'] == "") {
            $oenNumbersf = NULL;
        } else {
            $oenNumbers = $data['oenNumbers']['array'];

            $oenNumbersf = $this->unique_multidim_array($oenNumbers, 'oeNumber');

        }
        $oenNumbersN = Null;
        if ($oenNumbersf !== null) {
            foreach ($oenNumbersf as $item) {
                if ($item['brandName'] == 'NISSAN' || $item['brandName'] == 'INFINITI') {
                    $oenNumbersN[] = $item;
                }

            }
        }

//dump($oenNumbersf);


//        dump($articleAttributes, $articleDocuments, $assignedArticle, $eanNumber, $oenNumbers,$oenNumbersf);
        return view('pegasus.sparesimage')->with(['mark'              => $manuId,
            'model'             => $modId,
            'modifs'            => $carId,
            'maintree'          => $mtree,
            'parentNodeId'      => $parentNodeId,
            'GroupNodeId'       => $GroupNodeId,
            'brandName'         => $brandName,
            'articleAttributes' => $articleAttributes,
            'articleDocuments'  => $articleDocuments,
            'assignedArticle'   => $assignedArticle,
            'eanNumber'         => $eanNumber,
            'oenNumbersf'       => $oenNumbersN,
            'articleId'         => $articleId,
            'articleLinkId'     => $articleLinkId,
        ]);
    }

    public function getSparesListInfoFull1($manuId, $modId, $carId, $mtree, $parentNodeId, $SubGroupNodeId, $GroupNodeId, $articleId, $articleLinkId, $brandName)
    {
       $articleIdPairs =[];
        $function = 'getAssignedArticlesByIds6';
        $articleIdPairs[] =  ['articleId' => $articleId, 'articleLinkId' => $articleLinkId];
	//	dump((object)['array' => $articleIdPairs]);
		
		$rrr = (object)['array' => $articleIdPairs];
        $params = [
            'articleCountry'       => 'RU',
            'articleIdPairs'       => json_encode($rrr),
            'attributs'            => true,
            'basicData'            => true,
            'documents'            => true,
            'eanNumbers'           => true,
            'info'                 => true,
            'lang'                 => 'ru',
            'linkingTargetId'      => $carId,
            'linkingTargetType'    => 'P',
            'mainArticles'         => true,
            'manuId'               => $manuId,
            'modId'                => $modId,
            'normalAustauschPrice' => false,
            'oeNumbers'            => true,
            'prices'               => false,
            'provider'             => config('apiconnect.provider'),
            'replacedByNumbers'    => true,
            'replacedNumbers'      => true,
            'thumbnails'           => true,
            'usageNumbers'         => true,

        ];
//dump($params);
        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);

//        dump($jsonRequest);
        $data = $jsonRequest['data']['array']['0'];

//        dump($data);
//        dump(Cache::tags(['sp',$manuId,$modId,$carId,$mtree,$parentNodeId,$SubGroupNodeId,$GroupNodeId])->get($brandName));
        if ($data['articleAttributes'] == "") {
            $articleAttributes = NULL;
        } else {
            $articleAttributes = $data['articleAttributes']['array'];
        }


        if ($data['articleDocuments'] == "") {
            $articleDocuments = NULL;
        } else {
            $articleDocuments = $data['articleDocuments']['array'];
        }

//        dump($articleDocuments);
        if ($data['assignedArticle'] == "") {
            $assignedArticle = NULL;
        } else {
            $assignedArticle = $data['assignedArticle'];
        }
        if ($data['eanNumber'] == "") {
            $eanNumber = NULL;
        } else {
            $eanNumber = $data['eanNumber']['array']['0'];
        }

        if ($data['oenNumbers'] == "") {
            $oenNumbersf = NULL;
        } else {
            $oenNumbers = $data['oenNumbers']['array'];

            $oenNumbersf = $this->unique_multidim_array($oenNumbers, 'oeNumber');

        }
        $oenNumbersN = Null;
        if ($oenNumbersf !== null) {
            foreach ($oenNumbersf as $item) {
                if ($item['brandName'] == 'NISSAN' || $item['brandName'] == 'INFINITI') {
                    $oenNumbersN[] = $item;
                }

            }
        }

//dump($oenNumbersf);


//        dump($articleAttributes, $articleDocuments, $assignedArticle, $eanNumber, $oenNumbers,$oenNumbersf);
        return view('pegasus.sparesimage1')->with(['mark'              => $manuId,
            'model'             => $modId,
            'modifs'            => $carId,
            'maintree'          => $mtree,
            'parentNodeId'      => $parentNodeId,
            'SubGroupNodeId'    => $SubGroupNodeId,
            'GroupNodeId'       => $GroupNodeId,
            'brandName'         => $brandName,
            'articleAttributes' => $articleAttributes,
            'articleDocuments'  => $articleDocuments,
            'assignedArticle'   => $assignedArticle,
            'eanNumber'         => $eanNumber,
            'oenNumbersf'       => $oenNumbersN,
            'articleId'         => $articleId,
            'articleLinkId'     => $articleLinkId,
        ]);
    }

    public function getBrands()
    {

        $function = 'getAmBrands';

        $params = [
            'articleCountry' => 'RU',
            'lang'           => 'ru',
            'provider'       => config('apiconnect.provider'),
        ];
        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
        $data = $jsonRequest['data']['array'];
//        dd($data );
        return $data;
    }
}