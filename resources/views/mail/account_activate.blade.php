<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.06.2016
 * Time: 13:56
 */?>
Для активации аккаунта пройдите по <a href="{{ URL::to("activate/{$sentuser->getUserId()}/{$code}") }}">ссылке</a>
