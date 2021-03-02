<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;

class OrderInvoise extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

//        dd($notifiable->order_id);
        return ['mail','database',OneSignalChannel::class];

    }


//    public function message($notifiable)
//    {
//        return $this->line('A new post was published on Laravel News!')
//            ->action('Read Post', url($this->post->slug))
//            ->line('Please don\'t forget to share.');
//    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     *
     *
     */


    public function toMail($notifiable)
    {
       //dd($notifiable->order_id);
        // dd($notifiable);
        return (new MailMessage)
            ->subject('Поступил новый заказ!')
            ->line('На сайте был создан новый заказ!')
            ->action('Посмотреть', url($this->order->id)
            );

    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
//        dd($notifiable);
        return [
            'title' => 'Новый заказ!',
            'body' => 'На сайте был создан новый заказ.',
            'action_url' => 'https://laravel.com',
            'created' => Carbon::now()->toIso8601String()
        ];
    }
//
    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
                               ->subject("{$notifiable->service} Поступил новый заказ")
                               ->body("Посмотреть.")
                               ->url('http://onesignal.com')
                               ->webButton(
                                   OneSignalWebButton::create('link-1')
                                                     ->text('Click here')
                                                     ->icon('http://test.acmarshal.ru/images/Toyota.png')
                                                     ->url('http://laravel.com')
                               );
    }
}
