<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_post_id',
        'user_id',
        'cover_letter',
        'bid_amount',
        'estimated_duration',
        'attachment',
        'status',
        'feedback',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job post that the application belongs to.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    /**
     * Get the user (job seeker) who submitted the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the application has been accepted.
     *
     * @return bool
     */
    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the application has been rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the application is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the application has been withdrawn.
     *
     * @return bool
     */
    public function isWithdrawn()
    {
        return $this->status === 'withdrawn';
    }

    /**
     * Get the status formatted for display.
     *
     * @return string
     */
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
            case 'accepted':
                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            case 'rejected':
                return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
            case 'withdrawn':
                return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        }
    }
} 