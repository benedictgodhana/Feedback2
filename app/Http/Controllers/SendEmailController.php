<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailUserMail;
use Inertia\Inertia;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendReply(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $email = $request->input('email');
        $message = $request->input('message');

        // Append the no-reply text to the bottom of the message
        $messageWithNoReply = $message . "\n\n Please do not reply to this email.";

        Mail::raw($messageWithNoReply, function ($mail) use ($email) {
            $mail->to($email)
                 ->subject('Reply to Your Feedback - No Reply');
        });

        Reply::create([
            'email' => $email,
            'message' => $message,
        ]);
    }



    public function sendTestEmail()
    {
        $user = new \stdClass();
        $user->email = 'allanmurimi96@gmail.com';
        $user->send_subject = 'Test Email';
        $user->send_message = 'This is a test email.';

        Mail::to($user->email)->send(new SendEmailUserMail($user));

        return 'Test email sent!';
    }
}
