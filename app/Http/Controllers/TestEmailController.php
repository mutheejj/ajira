<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestEmailController extends Controller
{
    /**
     * Show the test email form.
     */
    public function index()
    {
        // Get environment email settings to display on the form
        $emailSettings = [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
            'MAIL_FROM_NAME' => config('mail.from.name'),
        ];

        return view('emails.test-form', compact('emailSettings'));
    }

    /**
     * Send a test email.
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $email = $request->email;
        $subject = $request->subject;
        $content = $request->content;

        try {
            Mail::to($email)->send(new TestMail($subject, $content));
            
            return back()->with('success', 'Test email sent successfully! Check your email inbox or spam folder.');
        } catch (\Exception $e) {
            Log::error('Test email error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to send test email. Error: ' . $e->getMessage())
                ->withInput();
        }
    }
}
