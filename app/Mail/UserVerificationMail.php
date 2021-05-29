<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $token;
    private $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userToken, $userId)
    {
        $this->token = $userToken;
        $this->id = $userId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = 'http://127.0.0.1:8000/account/verificate?id='.$this->id.'&token='.$this->token;
        $data = [
            "token" => $this->token,
            "id" => $this->id,
            "url" => $url,
        ];
        //return $this->markdown('emails.email_verification', $data);
        return $this->from('vervays@ebookstore.com')
                    ->markdown('emails.email_verification')
                    ->with($data);
    }
}
