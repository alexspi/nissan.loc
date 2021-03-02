<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecdoc_nissan extends Model
{
    protected $table = 'tecdoc_niss';

    /**
     * @var array
     */
    protected $fillable = [

        'MOD_ID',
        'MOD_CDS_TEXT',
        'MOD_PCON_START',
        'MOD_PCON_END',
        'URL',
        'groupe',

    ];
}
