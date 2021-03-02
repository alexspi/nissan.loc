<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.09.2016
 * Time: 16:42
 */

namespace App\Models\TecDoc;

use Illuminate\Database\Eloquent\Model;

class Spares extends Model
{
    protected $connection ='tecdoc';

    protected $table = 'link_ga_str';
}