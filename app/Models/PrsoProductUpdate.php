<?php

namespace App\Models;

use App\Models\PrsoProduct;
use Request;


class PrsoProductUpdate extends PrsoProduct 
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'prso_products';
    protected $guarded = ['id'];


}