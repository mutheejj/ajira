<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $oldStatus;

    /**
     * Create a new message instance.
     *
     * @param  Application  $application
     * @param  string  $oldStatus
     * @return void
     */
    public function __construct(Application $application, string $oldStatus)
    {
        $this->application = $application;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $statusVerb = match($this->application->status) {
            'accepted' => 'accepted',
            'rejected' => 'rejected',
            'withdrawn' => 'withdrawn',
            default => 'updated'
        };

        return $this->subject("Your Application was $statusVerb: " . $this->application->jobPost->title)
                    ->markdown('emails.applications.status-changed')
                    ->with([
                        'application' => $this->application,
                        'jobPost' => $this->application->jobPost,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->application->status,
                        'feedback' => $this->application->feedback,
                    ]);
    }
} 