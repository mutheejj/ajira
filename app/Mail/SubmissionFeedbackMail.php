<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $jobSeeker;
    public $client;

    /**
     * Create a new message instance.
     *
     * @param Submission $submission
     * @param User $jobSeeker
     * @param User $client
     * @return void
     */
    public function __construct(Submission $submission, User $jobSeeker, User $client)
    {
        $this->submission = $submission;
        $this->jobSeeker = $jobSeeker;
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->submission->status === 'approved' 
            ? 'Submission Approved: ' . $this->submission->task->title
            : 'Feedback Received: ' . $this->submission->task->title;
            
        return $this->subject($subject)
                    ->view('emails.submission-feedback')
                    ->with([
                        'taskUrl' => route('jobseeker.workspace', $this->submission->task->id),
                    ]);
    }
} 