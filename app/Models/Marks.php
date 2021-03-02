<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;

class Marks extends Model
{
    use SoftDeletes, Sluggable, LocalizedEloquentTrait;

    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'manuId',
        'logo',
        'status',
    ];
    public function models()
    {
        return $this->hasMany(ModelsCars::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
