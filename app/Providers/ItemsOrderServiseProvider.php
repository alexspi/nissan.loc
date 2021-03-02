<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.11.2016
 * Time: 17:59
 */

namespace App\Providers;
use \Backpack\CRUD\CrudServiceProvider;
use Route;

class ItemsOrderServiseProvider extends CrudServiceProvider
{

    public static function resource($name, $controller, array $options = [])
    {
        Route::post($name.'/{id}/items', [
            'as' => 'crud.'.$name.'.itemOrder',
            'uses' => $controller.'@itemOrder',
        ]);

    }

}