<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The subject of the email.
     *
     * @var string
     */
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param string $subject
     * @return void
     */
    public function __construct($user, $subject = 'Welcome Email')
    {
        $this->user = $user;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome') // Ensure this view path is correct
                    ->subject($this->subject) // Set the subject
                    ->with([
                        'name' => $this->user->name, // Pass the user's name to the view
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
