<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category',
        'bio',
        'hourly_rate',
        'availability',
        'education',
        'experience',
        'portfolio_items',
        'languages',
        'location',
        'phone',
        'address',
        'social_links',
        'certifications',
        'preferences'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'portfolio_items' => 'array',
        'languages' => 'array',
        'social_links' => 'array',
        'certifications' => 'array',
        'preferences' => 'array',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 