<?php

namespace App\Listeners;

use App\Mail\EmailSend;
use App\Events\MailSendEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSendListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MailSendEvent $event)
    {
        //print_r($event->mailData);exit();
        Mail::to($event->mailData['email'])->send(new EmailSend($event->mailData));
    }
}
