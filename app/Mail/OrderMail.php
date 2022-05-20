<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $order, $owner, $client, $view, $order_items;

    public function __construct($order, $owner, $client, $view, $subject, $email_from = null)
    {
        $this->order = $order;
        $this->owner = $owner;
        $this->client = $client;
        $this->view = $view;
        $this->subject = $subject;
        $this->from[] = [
            'address' => $email_from ?? config('mail.from.address'),
            'name' => config('mail.from.name'),
        ];
    }

    public function build()
    {
        return $this->view('mails.' . $this->view)->with(
            [
                'order' => $this->order,
                'owner' => $this->owner,
                'client' => $this->client,
                'subject' => $this->subject
            ]);
    }
}
