<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $email, $message, $full_name;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->email = $data["email"];
        $this->full_name = $data["full_name"];
        $this->message = $data["message"];
        $this->subject = Lang::get('email.Contact message from') . ' ' . config('app.name') . '!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mails.contact')->with(['email' => $this->email, 'text' => $this->message, 'full_name' => $this->full_name]);
    }
}
