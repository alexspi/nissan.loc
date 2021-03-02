<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
use Backpack\CRUD\CrudTrait;

class ModelsCars extends Model
{
    use CrudTrait,SoftDeletes, Sluggable, LocalizedEloquentTrait;

    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'models';

    protected $fillable = [
        'name',
        'slug',
        'mark_id',
        'manuId',
        'modelId',
        'modelname',
        'yearOfConstrFrom',
        'yearOfConstrTo',
        'status'

    ];
    public function marks()
    {
        return $this->belongsTo(Marks::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'modelname'
            ]
        ];
    }
}
