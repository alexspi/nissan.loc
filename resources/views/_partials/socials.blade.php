<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.12.2016
 * Time: 11:06
 */?>

<div class="d-flex flex-row mx-0 px-0">
    <div class="btn but but--reg mt-3 mx-2 w-50">
        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="p-2" role="button" style="color: #ffffff;"><i class="fa fa-lg fa-facebook" aria-hidden="true"></i></a>
    </div>
    <div class="btn but but--reg mt-3 mx-2 w-50">
        <a href="{{ route('social.redirect', ['provider' => 'vkontakte']) }}" class="p-2" role="button" style="color: #ffffff;"><i class="fa fa-lg fa-vk" aria-hidden="true"></i></a>
    </div>
</div>




