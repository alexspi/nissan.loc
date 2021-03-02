<?php

namespace App\Models;

//use OrderUsers;
//use App\Models\OrderItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Events\OrderPublishedEvent;
use Backpack\CRUD\CrudTrait;


Class Order extends Model
{
    use CrudTrait;
    use Notifiable;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['user_data', 'total', 'status', 'created_at'];

    const STATUS_DRAFT = 0;
    const STATUS_NEW = 1;

    public static function boot()
    {
        static::saving(function ($instance) {
            //Мы проверяем статус статьи – если он «Опубликован», смотрим на статус оповещения, если он еще не «Опубликован»
            if ($instance->status == self::STATUS_NEW && $instance->notify_status < self::STATUS_NEW) {

                //то устанавливаемый статус оповещения в «опубликован»
                $instance->notify_status = self::STATUS_NEW;

                //и  «выстреливаем» событие PostPublishedEvent, передавая в него собственный инстанс.
                \Event::fire(new OrderPublishedEvent($instance));
            };
            parent::boot();
        });
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function OrderUsers()
    {
        return $this->belongsTo(OrderUsers::class);
    }


}
