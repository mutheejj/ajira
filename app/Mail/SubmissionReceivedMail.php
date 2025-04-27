<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $task;
    public $jobSeeker;
    public $client;

    /**
     * Create a new message instance.
     *
     * @param Submission $submission
     * @param Task $task
     * @param User $jobSeeker
     * @param User $client
     * @return void
     */
    public function __construct(Submission $submission, Task $task, User $jobSeeker, User $client)
    {
        $this->submission = $submission;
        $this->task = $task;
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
        return $this->subject('New Submission Received: ' . $this->task->title)
                    ->view('emails.submission-received')
                    ->with([
                        'taskUrl' => route('client.task-details', $this->task->id),
                    ]);
    }
} 