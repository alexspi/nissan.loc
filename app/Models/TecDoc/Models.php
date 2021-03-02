<?php

namespace App\Models\TecDoc;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $connection ='tecdoc';

    protected $table = 'models';
    protected $fillable = [
        'MOD_ID', 'TEX_TEXT as MOD_CDS_TEXT', 'MOD_PCON_START', 'MOD_PCON_END'
    ];

}
