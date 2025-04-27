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
        'task_id',
        'amount',
        'type',
        'description',
        'status',
        'reference',
        'balance_before',
        'balance_after',
        'meta',
        'currency',
        'payment_method',
        'payment_provider',
        'transaction_id',
        'payment_details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'payment_details' => 'array',
    ];

    /**
     * The attributes that should be set to default values.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pending',
        'currency' => 'USD',
    ];

    /**
     * Transaction types
     */
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';

    /**
     * Transaction statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the task that the transaction belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include transactions of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Format amount with currency symbol.
     */
    public function getFormattedAmountAttribute()
    {
        $currency = $this->currency ?? 'USD';
        
        switch ($currency) {
            case 'USD':
                return '$' . number_format(abs($this->amount), 2);
            case 'KSH':
                return 'KSh' . number_format(abs($this->amount), 2);
            default:
                return '$' . number_format(abs($this->amount), 2);
        }
    }
} 