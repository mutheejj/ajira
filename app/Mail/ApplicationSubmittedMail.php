<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     *
     * @param  Application  $application
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Application Received: ' . $this->application->jobPost->title)
                    ->markdown('emails.applications.submitted')
                    ->with([
                        'application' => $this->application,
                        'jobPost' => $this->application->jobPost,
                        'applicant' => $this->application->user,
                        'client' => $this->application->jobPost->client,
                    ]);
    }
} 