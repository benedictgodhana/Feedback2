<?php
// app/Mail/PasswordReset.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    public function __construct($user, $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->view('emails.password_reset')
                    ->with([
                        'name' => $this->user->name,
                        'resetUrl' => $this->resetUrl,
                    ]);
    }
}
