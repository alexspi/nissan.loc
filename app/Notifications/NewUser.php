<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;


class NewUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
                               ->subject("{$notifiable->service} Поступил новый заказ")
                               ->body("Click here to see details.")
                               ->url('http://onesignal.com')
                               ->webButton(
                                   OneSignalWebButton::create('link-1')
                                                     ->text('Click here')
                                                     ->icon('https://upload.wikimedia.org/wikipedia/commons/4/4f/Laravel_logo.png')
                                                     ->url('http://laravel.com')
                               );
    }
}
