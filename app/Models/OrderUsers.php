<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

Class OrderUsers extends Model {

//    use CrudTrait;
    protected $primaryKey = 'id';

    protected $table = 'order_users';

    protected $fillable =['order_id','user_name', 'user_email'];

    public function Orders()
    {
        return $this->hasMany('App\Models\Order','user_data');
    }

}
