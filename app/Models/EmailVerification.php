<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmailVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the email verification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($verification) {
            if (empty($verification->code)) {
                $verification->code = self::generateCode();
            }
            // Set expiry to 24 hours from now if not set
            if (empty($verification->expires_at)) {
                $verification->expires_at = now()->addHours(24);
            }
        });
    }

    /**
     * Generate a random 6-digit verification code.
     *
     * @return string
     */
    public static function generateCode()
    {
        return (string) random_int(100000, 999999);
    }

    /**
     * Check if the verification code has expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        return now()->isAfter($this->expires_at);
    }
} 