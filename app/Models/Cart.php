<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Cart extends Model {

    protected $table = 'carts';

    protected $fillable = array('user_id','catalog_id','amount','total');

    public function Catalogs(){

        return $this->belongsTo(\App\Model\PrsoProduct::class,'catalog_id');

    }

}