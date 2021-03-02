<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($providerUser,$pass)
    {
        $this->providerUser = $providerUser;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $providerUser =$this->providerUser;
        $pass =$this->pass;
        return $this->view('mail.UserRegister')
                    ->subject('Новая регистрация')
                    ->with([
                        'user' => $this->providerUser->name,
                        'login' => $this->providerUser->email,
                        'pass'=>$pass,

                    ]);
    }
}
