<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $verification_link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $verification_link)
    {
        //
        $this->email = $email;
        $this->name = $name;
        $this->verification_link = $verification_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.confirmation');
    }
}
