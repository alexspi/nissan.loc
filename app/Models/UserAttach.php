<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Events\AttachPublishedEvent;
use Backpack\CRUD\CrudTrait;
class UserAttach extends Model
{
    use Notifiable,CrudTrait;

    protected $table = 'userattach';

    protected $fillable = ['mark','model','year','engine','engine_type','vin','detail','phone','article', 'email', 'name', 'connect_type','comment','created_at'];

    const STATUS_DRAFT = 0;
    const STATUS_NEW = 1;
 public $timestamps = true;
    public static function boot()
    {

        static::saving(function ($instance) {
            //Мы проверяем статус статьи – если он «Опубликован», смотрим на статус оповещения, если он еще не «Опубликован»
            if ($instance->status == self::STATUS_NEW && $instance->notify_status < self::STATUS_NEW ) {
//                dd('yyyy');
                //то устанавливаемый статус оповещения в «опубликован»
                $instance->notify_status = self::STATUS_NEW;
//dd($instance);
                //и  «выстреливаем» событие PostPublishedEvent, передавая в него собственный инстанс.
                \Event::fire(new AttachPublishedEvent($instance));
            };
            parent::boot();
        });
    }

//    public  function  recordPushNotifySuccess()
//    {
//        $this->notify_status = self::STATUS_NEW;
//        $this->save();
//    }

}
