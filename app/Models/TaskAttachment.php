<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'file_name',
        'file_path',
        'file_size',
    ];

    /**
     * Get the task that owns the attachment.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get file URL attribute.
     * 
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
} 