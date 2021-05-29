<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    private $token;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userToken, $email)
    {
        $this->token = $userToken;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = 'http://127.0.0.1:8000/account/reset/password/from/email?email='.$this->email.'&token='.$this->token;
        $data = [
            "firstName" => User::getFirstNameByEmail($this->email),
            "url" => $url,
        ];
        return $this->from('vervays@ebookstore.com')
                    ->markdown('emails.forgot_password')
                    ->with($data);
    }
}
