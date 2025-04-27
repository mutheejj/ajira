<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $client;
    public $jobSeeker;

    /**
     * Create a new message instance.
     *
     * @param Task $task
     * @param User $client
     * @param User $jobSeeker
     * @return void
     */
    public function __construct(Task $task, User $client, User $jobSeeker)
    {
        $this->task = $task;
        $this->client = $client;
        $this->jobSeeker = $jobSeeker;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Task Assigned: ' . $this->task->title)
                    ->view('emails.task-assigned')
                    ->with([
                        'taskUrl' => route('jobseeker.workspace', $this->task->id),
                    ]);
    }
} 