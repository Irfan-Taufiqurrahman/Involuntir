<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;

    protected $link;

    public function __construct($user, $link)
    {
        $this->user = $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification')
            ->from('noreply@peduly.com', 'Peduly')
            ->view('emails.verify_email')
            ->with([
                'user' => $this->user->name,
                'link' => $this->link,
            ]);
    }
}
