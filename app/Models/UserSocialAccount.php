<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 28.12.2016
 * Time: 12:51
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{

    protected $table = 'user_social_account';
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}