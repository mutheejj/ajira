<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $task;
    public $sender;
    public $receiver;

    /**
     * Create a new message instance.
     *
     * @param Message $message
     * @param Task $task
     * @param User $sender
     * @param User $receiver
     * @return void
     */
    public function __construct(Message $message, Task $task, User $sender, User $receiver)
    {
        $this->message = $message;
        $this->task = $task;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New Message: ' . $this->task->title;
            
        return $this->subject($subject)
                    ->view('emails.new-message')
                    ->with([
                        'taskUrl' => $this->receiver->type === 'client' 
                            ? route('client.task-details', $this->task->id)
                            : route('jobseeker.workspace', $this->task->id),
                    ]);
    }
} 