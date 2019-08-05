<?php

namespace App\Listeners;

use App\Events\Registration;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registration  $event
     * @return void
     */
    public function handle(Registration $event)
    {
        //

        Mail::to($event->email)->send(new WelcomeEmail($event->name, $event->email));
    }
}
