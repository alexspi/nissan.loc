<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Meta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Defaults
        Meta::setTitle('Каталог оригинальных запчастей для Nissan,Infiniti ');
        Meta::setMetaDescription('Оригинальные запчасти для Nissan,Infiniti в Санкт-Петербурге');
    }
}
