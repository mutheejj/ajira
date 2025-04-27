<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show payment methods selection form
     */
    public function showPaymentMethods()
    {
        $wallet = $this->getWallet();
        return view('wallet.payment-methods', compact('wallet'));
    }

    /**
     * Show card payment form
     */
    public function showCardForm()
    {
        $wallet = $this->getWallet();
        return view('wallet.card-payment', compact('wallet'));
    }

    /**
     * Process card payment
     */
    public function processCardPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|in:USD,KSH',
            'card_number' => 'required|string|min:16|max:19',
            'expiry_month' => 'required|numeric|min:1|max:12',
            'expiry_year' => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 20),
            'cvv' => 'required|string|min:3|max:4',
            'card_holder' => 'required|string|max:255',
        ]);
        
        // In a production app, you would integrate with a payment gateway like Stripe, Paystack, or Flutterwave
        // For this demo, we'll simulate a successful payment
        
        $amount = $request->amount;
        $currency = $request->currency;
        $lastFour = substr($request->card_number, -4);
        
        // Create transaction record
        $transaction = Transaction::create([
            'wallet_id' => $this->getWallet()->id,
            'amount' => $amount,
            'type' => 'deposit',
            'description' => 'Card deposit',
            'reference' => 'CARD-' . Str::random(8),
            'status' => 'completed',
            'currency' => $currency,
            'payment_method' => 'card',
            'payment_provider' => 'demo',
            'transaction_id' => 'CARD' . time(),
            'meta' => json_encode([
                'card_last_four' => $lastFour,
                'card_type' => $this->getCardType($request->card_number),
            ])
        ]);
        
        // Update wallet balance
        $wallet = $this->getWallet();
        $this->updateWalletBalance($wallet, $amount, $currency);
        
        // Update transaction with new balance
        $transaction->balance_after = $this->getBalanceForCurrency($wallet, $currency);
        $transaction->save();
        
        return redirect()->route('wallet.index')
            ->with('success', $this->formatAmountWithCurrency($amount, $currency) . ' has been successfully added to your wallet');
    }

    /**
     * Show cryptocurrency payment form
     */
    public function showCryptoForm()
    {
        $wallet = $this->getWallet();
        
        // Get current crypto rates (in a real app, you would use an API like CoinGecko or Binance)
        $cryptoRates = [
            'BTC' => [
                'USD' => 47500.25,
                'KSH' => 5988650.25,
            ],
            'ETH' => [
                'USD' => 2500.75,
                'KSH' => 340175.25,
            ],
            'USDT' => [
                'USD' => 1.00,
                'KSH' => 138.50,
            ],
        ];
        
        return view('wallet.crypto-payment', compact('wallet', 'cryptoRates'));
    }

    /**
     * Process cryptocurrency payment
     */
    public function processCryptoPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'wallet_currency' => 'required|in:USD,KSH',
            'crypto_currency' => 'required|in:BTC,ETH,USDT',
        ]);
        
        // Generate a unique wallet address for the payment
        // In a real app, you would integrate with a crypto payment processor like CoinPayments
        $cryptoAddress = $this->generateDummyCryptoAddress($request->crypto_currency);
        
        // Save pending transaction
        $transaction = Transaction::create([
            'wallet_id' => $this->getWallet()->id,
            'amount' => $request->amount,
            'type' => 'deposit',
            'description' => 'Crypto deposit via ' . $request->crypto_currency,
            'reference' => 'CRYPTO-' . Str::random(8),
            'status' => 'pending',
            'currency' => $request->wallet_currency,
            'payment_method' => 'crypto',
            'payment_provider' => 'crypto_' . strtolower($request->crypto_currency),
            'meta' => json_encode([
                'crypto_currency' => $request->crypto_currency,
                'crypto_address' => $cryptoAddress,
                'exchange_rate' => $this->getDummyCryptoRate($request->crypto_currency, $request->wallet_currency)
            ])
        ]);
        
        // In a real app, you would redirect to a payment processor or show QR code
        return view('wallet.crypto-checkout', [
            'transaction' => $transaction,
            'cryptoAddress' => $cryptoAddress,
            'crypto_currency' => $request->crypto_currency,
            'amount' => $request->amount,
            'wallet_currency' => $request->wallet_currency,
            'crypto_amount' => $this->convertToCrypto(
                $request->amount,
                $request->wallet_currency,
                $request->crypto_currency
            )
        ]);
    }

    /**
     * Simulate crypto payment completion (in a real app this would be a webhook/callback)
     */
    public function completeCryptoPayment($transactionId)
    {
        $transaction = Transaction::find($transactionId);
        
        if (!$transaction || $transaction->wallet->user_id !== Auth::id()) {
            return redirect()->route('wallet.index')->with('error', 'Invalid transaction.');
        }
        
        if ($transaction->status != 'pending') {
            return redirect()->route('wallet.index')->with('error', 'Transaction is not pending.');
        }
        
        // Update wallet balance
        $wallet = $this->getWallet();
        $this->updateWalletBalance($wallet, $transaction->amount, $transaction->currency);
        
        // Update transaction
        $transaction->status = 'completed';
        $transaction->balance_after = $this->getBalanceForCurrency($wallet, $transaction->currency);
        $transaction->save();
        
        return redirect()->route('wallet.index')
            ->with('success', $this->formatAmountWithCurrency($transaction->amount, $transaction->currency) . 
                ' has been successfully added to your wallet via cryptocurrency.');
    }

    /**
     * Get user's wallet
     */
    private function getWallet()
    {
        $userId = Auth::id();
        return Wallet::where('user_id', $userId)->first();
    }

    /**
     * Update wallet balance based on currency
     */
    private function updateWalletBalance($wallet, $amount, $currency)
    {
        switch (strtoupper($currency)) {
            case 'USD':
                $wallet->usd_balance += $amount;
                break;
            case 'KSH':
                $wallet->ksh_balance += $amount;
                break;
            default:
                // Default processing logic (using USD)
                $wallet->usd_balance += $amount;
                break;
        }
        
        $wallet->save();
    }

    /**
     * Get balance for specific currency
     */
    private function getBalanceForCurrency($wallet, $currency)
    {
        switch (strtoupper($currency)) {
            case 'USD':
                return $wallet->usd_balance;
            case 'KSH':
                return $wallet->ksh_balance;
            default:
                // Default processing logic (using USD)
                return $wallet->usd_balance;
        }
    }

    /**
     * Format amount with currency symbol
     */
    private function formatAmountWithCurrency($amount, $currency)
    {
        switch (strtoupper($currency)) {
            case 'USD':
                return '$' . number_format($amount, 2);
            case 'KSH':
                return 'KSh' . number_format($amount, 2);
            default:
                // Default processing logic (using USD)
                return '$' . number_format($amount, 2);
        }
    }

    /**
     * Get card type based on card number
     */
    private function getCardType($cardNumber)
    {
        $firstDigit = substr($cardNumber, 0, 1);
        $firstTwoDigits = substr($cardNumber, 0, 2);
        
        if ($firstDigit == '4') {
            return 'Visa';
        } elseif ($firstTwoDigits >= 51 && $firstTwoDigits <= 55) {
            return 'MasterCard';
        } elseif ($firstTwoDigits == 34 || $firstTwoDigits == 37) {
            return 'American Express';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Generate a dummy crypto address for demo purposes
     */
    private function generateDummyCryptoAddress($crypto)
    {
        $prefix = '';
        $length = 42;
        
        switch (strtoupper($crypto)) {
            case 'BTC':
                $prefix = 'bc1';
                $length = 32;
                break;
            case 'ETH':
                $prefix = '0x';
                $length = 40;
                break;
            case 'USDT':
                $prefix = '0x';
                $length = 40;
                break;
        }
        
        $chars = '0123456789abcdef';
        $address = $prefix;
        
        for ($i = 0; $i < $length; $i++) {
            $address .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        return $address;
    }

    /**
     * Get dummy crypto exchange rate
     */
    private function getDummyCryptoRate($crypto, $currency)
    {
        $rates = [
            'BTC' => [
                'USD' => 47500.25,
                'KSH' => 5988650.25,
            ],
            'ETH' => [
                'USD' => 2500.75,
                'KSH' => 340175.25,
            ],
            'USDT' => [
                'USD' => 1.00,
                'KSH' => 138.50,
            ],
        ];
        
        return $rates[$crypto][$currency] ?? 0;
    }

    /**
     * Convert fiat amount to crypto amount
     */
    private function convertToCrypto($amount, $fiatCurrency, $cryptoCurrency)
    {
        $rate = $this->getDummyCryptoRate($cryptoCurrency, $fiatCurrency);
        if ($rate == 0) return 0;
        
        return $amount / $rate;
    }
}
