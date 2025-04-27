<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'description',
        'hours_worked',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'submission_type',
        'external_link',
        'submission_text',
        'is_final',
        'status',
        'feedback',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hours_worked' => 'decimal:2',
        'file_size' => 'integer',
        'is_final' => 'boolean',
    ];

    /**
     * Get the task that owns the submission.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user that created the submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the submission has been approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the submission has been rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the submission is pending review.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Get the file URL for this submission.
     */
    public function getFileUrl()
    {
        if (!$this->file_path) {
            return null;
        }
        
        return asset('storage/' . $this->file_path);
    }
} 