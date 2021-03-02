<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
//use Order;

Class OrderItems extends Model {

    use CrudTrait;
    protected $table = 'order_items';

    protected $fillable =['order_id','orig_number', 'title', 'price','amount', 'ostatok'];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

}
