<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.01.2018
 * Time: 11:11
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ModelsCarCrudRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}