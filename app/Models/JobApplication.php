<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_seeker_id',
        'job_id',
        'cover_letter',
        'resume',
        'status',
        'current_step',
        'steps',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'steps' => 'array',
        'current_step' => 'integer',
        'applied_date' => 'datetime',
        'last_updated' => 'datetime',
    ];

    /**
     * The status options for a job application.
     */
    const STATUS_CHOICES = [
        'pending' => 'Pending',
        'reviewing' => 'Reviewing',
        'interviewed' => 'Interviewed',
        'rejected' => 'Rejected',
        'accepted' => 'Accepted',
    ];

    /**
     * Get the job seeker that owns the application.
     */
    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }

    /**
     * Get the job that the application is for.
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }

    /**
     * Update the status of the application.
     *
     * @param string $newStatus
     * @return void
     */
    public function updateStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->save();
    }

    /**
     * Advance to the next step of the application process.
     *
     * @return void
     */
    public function advanceStep()
    {
        if ($this->current_step < count($this->steps) - 1) {
            $this->current_step += 1;
            $this->save();
        }
    }

    /**
     * Set the steps for the application process.
     *
     * @param array $stepsList
     * @return void
     */
    public function setSteps($stepsList)
    {
        $this->steps = $stepsList;
        $this->save();
    }

    /**
     * Scope a query to only include pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted applications.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include rejected applications.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
} 