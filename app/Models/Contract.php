<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_id',
        'job_seeker_id',
        'client_id',
        'title',
        'description',
        'amount',
        'currency',
        'status',
        'start_date',
        'end_date',
        'payment_terms',
        'payment_schedule',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * The status options for a contract.
     */
    const STATUS_CHOICES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Get the job that the contract is for.
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }

    /**
     * Get the job seeker that owns the contract.
     */
    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }

    /**
     * Get the client that owns the contract.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the tasks for the contract.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
} 