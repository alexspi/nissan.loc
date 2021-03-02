<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.11.2016
 * Time: 14:26
 */

namespace App\Http\Controllers;
//use KodiCMS\Assets\Contracts\MetaInterface;
//use \KodiCMS\Assets\Contracts\SocialMediaTagsInterface;
use Meta;
//use App\Traits\MetaTag;

class IndexController extends Controller
{
//    use MetaTag;

//    public function __construct(Meta $meta)
//    {
//        parent::__construct();
//        $this->meta = $meta;

//    }

    public function index()
    {
        Meta::setTitle('Каталог оригинальных запчастей для Nissan,Infiniti ');
        Meta::setMetaDescription('Оригинальные запчасти для Nissan,Infiniti в Санкт-Петербурге');
        Meta::setMetaKeywords('nissan ');
        Meta::setMetaRobots('index,follow');

        return view('home');
    }
}