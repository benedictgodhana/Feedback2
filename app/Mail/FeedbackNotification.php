<?php
// app/Mail/FeedbackNotification.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;

    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->subject('New Feedback Received')
                    ->view('emails.feedback-notification');
    }
}
