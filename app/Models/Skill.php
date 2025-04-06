<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id'
    ];

    /**
     * The job posts that have this skill.
     */
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_skill');
    }

    /**
     * The users that have this skill.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill');
    }

    /**
     * The category that this skill belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
} 