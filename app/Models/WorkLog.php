<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'job_seeker_id',
        'description',
        'hours_spent',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hours_spent' => 'decimal:2',
        'date' => 'datetime',
    ];

    /**
     * Get the task that owns the work log.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the job seeker that owns the work log.
     */
    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }
} 