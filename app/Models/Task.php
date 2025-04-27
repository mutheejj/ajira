<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contract_id',
        'client_id',
        'job_seeker_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'progress',
        'estimated_hours',
        'actual_hours',
        'payment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'progress' => 'integer',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
    ];

    /**
     * The status options for a task.
     */
    const STATUS_CHOICES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * The priority options for a task.
     */
    const PRIORITY_CHOICES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ];

    /**
     * Get the contract that owns the task.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get the work logs for the task.
     */
    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    /**
     * Get the submissions for the task.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get the messages for the task.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest submission for the task.
     */
    public function latestSubmission()
    {
        return $this->hasOne(Submission::class)->latest();
    }

    /**
     * Get the final submission for the task.
     */
    public function finalSubmission()
    {
        return $this->hasOne(Submission::class)->where('is_final', true)->latest();
    }

    /**
     * Check if the task is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the task is in progress.
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the task is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Mark the task as completed.
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
        
        return $this;
    }

    /**
     * Get the client that owns the task.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the job seeker that the task is assigned to.
     */
    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }
    
    /**
     * Get the attachments for the task.
     */
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }
} 