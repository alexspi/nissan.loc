<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.06.2016
 * Time: 13:56
 */?>
Для создания нового пароля пройдите по <a href="{{ URL::to("reset/{$sentuser->getUserId()}/{$code}") }}">ссылке</a>
