<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'title',
        'category',
        'description',
        'requirements',
        'skills',
        'experience_level',
        'project_type',
        'budget',
        'currency',
        'duration',
        'location',
        'remote_work',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skills' => 'array',
        'budget' => 'decimal:2',
        'duration' => 'integer',
        'remote_work' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The status options for a job post.
     */
    const STATUS_CHOICES = [
        'active' => 'Active',
        'closed' => 'Closed',
        'draft' => 'Draft',
    ];

    /**
     * The experience level options for a job post.
     */
    const EXPERIENCE_LEVEL_CHOICES = [
        'entry' => 'Entry Level',
        'intermediate' => 'Intermediate',
        'expert' => 'Expert',
    ];

    /**
     * The project type options for a job post.
     */
    const PROJECT_TYPE_CHOICES = [
        'full_time' => 'Full Time',
        'part_time' => 'Part Time',
        'contract' => 'Contract',
        'freelance' => 'Freelance',
    ];

    /**
     * Get the client that owns the job post.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the applications for the job post.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_post_id');
    }

    /**
     * Get the users who saved this job post.
     */
    public function savedBy()
    {
        return $this->hasMany(SavedJob::class, 'job_id');
    }

    /**
     * Scope a query to only include active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include draft jobs.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include closed jobs.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
} 