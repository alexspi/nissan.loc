<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\CrudTrait;

class Brands extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'brands';

    protected $fillable = [
        'brandId',
        'brandLogoID',
        'brandName',
        'status'
    ];
}
