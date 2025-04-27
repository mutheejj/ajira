<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'balance',
        'reserved_balance',
        'currency',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'reserved_balance' => 'decimal:2',
    ];

    /**
     * The attributes that should be set to default values.
     *
     * @var array
     */
    protected $attributes = [
        'balance' => 0,
        'currency' => 'USD',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the wallet.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Get the available balance (total balance minus reserved).
     *
     * @return float
     */
    public function getAvailableBalanceAttribute()
    {
        return $this->balance - $this->reserved_balance;
    }

    /**
     * Add funds to the wallet.
     *
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @return Transaction
     */
    public function deposit($amount, $description = null, $meta = [])
    {
        $this->balance += $amount;
        $this->save();

        return $this->recordTransaction($amount, 'deposit', 'completed', $description, null, $meta);
    }

    /**
     * Withdraw funds from the wallet.
     *
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @return Transaction
     */
    public function withdraw($amount, $description = null, $meta = [])
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient funds');
        }

        $this->balance -= $amount;
        $this->save();

        return $this->recordTransaction(-$amount, 'withdrawal', 'completed', $description, null, $meta);
    }

    /**
     * Make a payment.
     *
     * @param float $amount
     * @param string $description
     * @param string $reference
     * @param array $meta
     * @return Transaction
     */
    public function payment($amount, $description = null, $reference = null, $meta = [])
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient funds');
        }

        $this->balance -= $amount;
        $this->save();

        return $this->recordTransaction(-$amount, 'payment', 'completed', $description, $reference, $meta);
    }

    /**
     * Record a transaction.
     *
     * @param float $amount
     * @param string $type
     * @param string $status
     * @param string $description
     * @param string $reference
     * @param array $meta
     * @return Transaction
     */
    protected function recordTransaction($amount, $type, $status, $description = null, $reference = null, $meta = [])
    {
        return $this->transactions()->create([
            'amount' => $amount,
            'type' => $type,
            'status' => $status,
            'description' => $description,
            'reference' => $reference,
            'meta' => json_encode($meta),
        ]);
    }

    /**
     * Format balance as currency
     */
    public function getFormattedBalanceAttribute()
    {
        $currency = $this->currency ?? 'USD';
        
        switch ($currency) {
            case 'USD':
                return '$' . number_format($this->balance, 2);
            case 'KSH':
                return 'KSh' . number_format($this->balance, 2);
            default:
                return '$' . number_format($this->balance, 2);
        }
    }
} 