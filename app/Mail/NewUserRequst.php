<?php

namespace App\Mail;

use App\Models\UserAttach;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRequst extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserAttach $userAttach)
    {
        $this->userattach = $userAttach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $userAttach =$this->userattach;

//        dd($userAttach);
        return $this->view('mail.UserReqest.new')
                    ->subject('Новая заявка на подбор детали')
                    ->with([
                        'userattach' => $userAttach,
                    ]);
    }
}
