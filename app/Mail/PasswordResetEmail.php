<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $reset_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $reset_link)
    {
        //
        $this->user = $user;
        $this->reset_link = $reset_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.reset');
    }
}
