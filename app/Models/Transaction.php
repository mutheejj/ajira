<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'status',
        'description',
        'reference',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
    
    /**
     * Get the user associated with the transaction via wallet.
     */
    public function user()
    {
        return $this->wallet->user();
    }
    
    /**
     * Scope for credit transactions (income)
     */
    public function scopeCredit($query)
    {
        return $query->whereIn('type', ['payment', 'deposit', 'refund']);
    }
    
    /**
     * Scope for debit transactions (expenses)
     */
    public function scopeDebit($query)
    {
        return $query->whereIn('type', ['withdrawal', 'fee', 'purchase']);
    }
} 