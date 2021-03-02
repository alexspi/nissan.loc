<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use CrudTrait;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}