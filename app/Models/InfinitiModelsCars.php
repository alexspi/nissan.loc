<?php

namespace App\Models;

use App\Models\ModelsCars;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InfinitiModelsCars extends ModelsCars
{
    protected static function boot()
    {
        parent::boot();

        // never let a company user see the users of other companies
        if (Auth::check()) {

            static::addGlobalScope('manuId', function (Builder $builder) {
                $builder->where('manuId', 1526);
            });
        }
    }
}
