<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.01.2018
 * Time: 18:16
 */

namespace App\Http\Controllers;


class RequestPegasusApiController extends Controller
{
    public $COUNTRY;
    public $LANGUAGE;
    public $PROVIDER;

    public function request($function, $data = [])
    {

        $this->LANGUAGE = isset($data['language']) ? $data['language'] : 'ru';
        $this->COUNTRY = isset($data['country']) ? $data['country'] : 'RU';
        $this->PROVIDER = isset($data['provider']) ? $data['provider'] : '120';

        unset($data['language']);
        unset($data['country']);
        unset($data['provider']);

        $params = ['lang' => $this->LANGUAGE, 'country' => $this->COUNTRY, 'provider' => $this->PROVIDER];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
//                dump($key,$value);
                $pos = strpos($value, '{');
//                dump($pos);
                if ($pos === false) {
                    $params[$key] = $value;
                } else {
                    $params[$key] = json_decode($value);
                }
            }
        }

        $app = app();

        $post = $app->make('stdClass');
        $post->$function = (object)$params;

//        dump($post);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Googlebot'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_URL, 'http://webservice.tecalliance.services/pegasus-3-0/info/proxy/services/TecdocToCatDLB.jsonEndpoint');
        curl_setopt($ch, CURLOPT_REFERER, 'http://webservice.tecalliance.services/pegasus-3-0/info/index.html');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8', 'Host: webservice.tecalliance.services']);

        $response = curl_exec($ch);
		// dump($response);
        curl_close($ch);
        return $response;
    }

    public function unique_multidim_array($array, $key)
    {
        $temp_array = [];
        $i = 0;
        $key_array = [];

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function in_array_field($needle, $needle_field, $haystack, $strict = false)
    {

        if ($strict) {
            foreach ($haystack as $item)

                if (in_array($needle, $item) === true)
                    return true;
        } else {
            foreach ($haystack as $item)
                if (in_array($needle, $item) === true)
                    return true;
        }
        return false;
    }

    public function notNullSpares($carId, $NodeId)
    {
        $function = 'getArticleIdsWithState';

        $params = [
            'articleCountry' => 'RU',
            'assemblyGroupNodeId' => $NodeId,
            'lang' => 'ru',
            'linkingTargetId' => $carId,
            'linkingTargetType' => 'P',
            'provider' => config('apiconnect.provider'),


        ];
//dump($params);
        $response = $this->request($function, $params);


        $jsonRequest = json_decode($response, true);
//        dump($jsonRequest);
        if ($jsonRequest['data'] == "") {

            return false;
        } else {
            return true;
        }

    }

    public function getSparesListInfo($manuId, $modId, $carId, $articleIdPairs)
    {
        $function = 'getAssignedArticlesByIds6';

        $params = [
            'articleCountry' => 'RU',
            'articleIdPairs' => json_encode($articleIdPairs),
            'attributs' => true,
            'basicData' => true,
            'documents' => true,
            'eanNumbers' => true,
            'info' => true,
            'lang' => 'ru',
            'linkingTargetId' => $carId,
            'linkingTargetType' => 'P',
            'mainArticles' => true,
            'manuId' => $manuId,
            'modId' => $modId,
            'normalAustauschPrice' => true,
            'oeNumbers' => true,
            'prices' => true,
            'provider' => config('apiconnect.provider'),
            'replacedByNumbers' => true,
            'replacedNumbers' => true,
            'thumbnails' => true,
            'usageNumbers' => true,

        ];

        $response = $this->request($function, $params);

        $jsonRequest = json_decode($response, true);
//        dump( $jsonRequest);
        $data = $jsonRequest['data']['array'];
        if ($data[0]['oenNumbers'] !== "") {
            if ($this->in_array_field('NISSAN', 'brandName', $data[0]['oenNumbers']['array']) == true) {
                if($data[0]['assignedArticle']['articleState'] !== 1){return false;}
                return true;
            } elseif ($this->in_array_field('INFINITI', 'brandName', $data[0]['oenNumbers']['array']) == true) {
                if($data[0]['assignedArticle']['articleState'] !== 1){return false;}
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

}