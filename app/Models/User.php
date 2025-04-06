<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'email_verified_at',
        // Client fields
        'company_name',
        'industry',
        'company_size',
        'website',
        'description',
        // Job Seeker fields
        'profession',
        'experience',
        'skills',
        'bio',
        // Profile media
        'profile_picture',
        'resume',
        'portfolio',
        // Social links
        'github_link',
        'linkedin_link',
        'personal_website',
        // Preferences
        'currency',
        'portfolio_description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array',
    ];

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        // Only hash if the password is not already hashed
        $this->attributes['password'] = 
            !str_starts_with($value, '$2y$') && !str_starts_with($value, '$2a$') ? 
            bcrypt($value) : $value;
    }

    /**
     * Get all job posts for a client.
     */
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'client_id');
    }

    /**
     * Get all job applications for a job seeker.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_seeker_id');
    }

    /**
     * Get all saved jobs for a job seeker.
     */
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class, 'job_seeker_id');
    }

    /**
     * Check if user is a client.
     */
    public function isClient()
    {
        return $this->user_type === 'client';
    }

    /**
     * Check if user is a job seeker.
     */
    public function isJobSeeker()
    {
        return $this->user_type === 'job-seeker';
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin' || $this->email === env('ADMIN_EMAIL');
    }

    /**
     * Get the user's profile completion percentage.
     */
    public function getProfileCompletionAttribute()
    {
        $totalFields = 0;
        $completedFields = 0;

        if ($this->isJobSeeker()) {
            // Core fields
            $requiredFields = [
                'name', 'email', 'profession', 'experience', 'skills', 'bio',
                'profile_picture', 'resume'
            ];
            $totalFields = count($requiredFields);

            foreach ($requiredFields as $field) {
                if (!empty($this->$field)) {
                    $completedFields++;
                }
            }
        } elseif ($this->isClient()) {
            // Core fields
            $requiredFields = [
                'name', 'email', 'company_name', 'industry', 'company_size',
                'website', 'description', 'profile_picture'
            ];
            $totalFields = count($requiredFields);

            foreach ($requiredFields as $field) {
                if (!empty($this->$field)) {
                    $completedFields++;
                }
            }
        }

        return $totalFields > 0 ? ($completedFields / $totalFields) * 100 : 0;
    }

    /**
     * Get email verification code.
     */
    public function emailVerification()
    {
        return $this->hasOne(EmailVerification::class);
    }

    /**
     * Get the roles associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
