<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MpesaController extends Controller
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $passkey;
    protected $shortCode;
    protected $callbackUrl;
    protected $baseUrl;
    protected $accessToken;

    public function __construct()
    {
        $this->middleware('auth');
        
        // Daraja API credentials - should be in .env
        $this->consumerKey = env('MPESA_CONSUMER_KEY', '');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET', '');
        $this->passkey = env('MPESA_PASSKEY', '');
        $this->shortCode = env('MPESA_SHORTCODE', '');
        $this->callbackUrl = env('MPESA_CALLBACK_URL', url('/api/mpesa/callback'));
        $this->baseUrl = env('MPESA_ENV') == 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke' 
            : 'https://api.safaricom.co.ke';
    }

    /**
     * Show M-Pesa payment form
     */
    public function showPaymentForm()
    {
        $wallet = $this->getWallet();
        return view('wallet.mpesa', compact('wallet'));
    }

    /**
     * Generate access token for Daraja API
     */
    private function getAccessToken()
    {
        $url = $this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials';
        
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($url);
        
        if ($response->successful()) {
            $this->accessToken = $response->json('access_token');
            return $this->accessToken;
        }
        
        Log::error('Failed to get M-Pesa access token: ' . $response->body());
        return null;
    }

    /**
     * Initiate STK Push for M-Pesa payment
     */
    public function initiateSTKPush(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|min:10|max:12',
            'amount' => 'required|numeric|min:1',
        ]);
        
        $phone = $request->phone_number;
        $amount = $request->amount;
        
        // Add country code if not present
        if (substr($phone, 0, 1) == '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // Get access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return back()->with('error', 'Failed to connect to M-Pesa. Please try again later.');
        }
        
        // Generate timestamp
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);
        
        // Prepare STK Push request
        $url = $this->baseUrl . '/mpesa/stkpush/v1/processrequest';
        
        $response = Http::withToken($accessToken)
            ->post($url, [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => 'Ajira Wallet' . Auth::id(),
                'TransactionDesc' => 'Wallet Deposit via M-Pesa',
            ]);
        
        if ($response->successful()) {
            $data = $response->json();
            $checkoutRequestId = $data['CheckoutRequestID'];
            
            // Save initial transaction record
            $transaction = Transaction::create([
                'wallet_id' => $this->getWallet()->id,
                'amount' => $amount,
                'type' => 'deposit',
                'description' => 'M-Pesa deposit',
                'reference' => 'MPESA-' . Str::random(8),
                'status' => 'pending',
                'currency' => 'KSH',
                'payment_method' => 'mpesa',
                'payment_provider' => 'safaricom',
                'transaction_id' => $checkoutRequestId,
                'meta' => json_encode([
                    'checkout_request_id' => $checkoutRequestId,
                    'phone' => $phone,
                    'merchant_request_id' => $data['MerchantRequestID']
                ])
            ]);
            
            // Store in session to check status later
            session(['mpesa_checkout_id' => $checkoutRequestId]);
            session(['mpesa_transaction_id' => $transaction->id]);
            
            return redirect()->route('mpesa.status')->with('success', 'Please complete the payment on your phone.');
        }
        
        Log::error('M-Pesa STK Push Failed: ' . $response->body());
        return back()->with('error', 'Failed to initiate M-Pesa payment: ' . $response->json('errorMessage', 'Unknown error'));
    }

    /**
     * Check the status of an STK Push request
     */
    public function checkTransactionStatus()
    {
        $checkoutRequestId = session('mpesa_checkout_id');
        $transactionId = session('mpesa_transaction_id');
        
        if (!$checkoutRequestId || !$transactionId) {
            return redirect()->route('wallet.index')->with('error', 'No active M-Pesa transaction found.');
        }
        
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return redirect()->route('wallet.index')->with('error', 'Transaction record not found.');
        }
        
        // If transaction is already completed, show success
        if ($transaction->status == 'completed') {
            session()->forget(['mpesa_checkout_id', 'mpesa_transaction_id']);
            return redirect()->route('wallet.index')->with('success', 'Your deposit of KSh' . number_format($transaction->amount, 2) . ' was successful.');
        }
        
        // Get access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return view('wallet.mpesa-status', [
                'transaction' => $transaction,
                'status' => 'unknown',
                'message' => 'Unable to check payment status at this time.'
            ]);
        }
        
        // Generate timestamp
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);
        
        // Query transaction status
        $url = $this->baseUrl . '/mpesa/stkpushquery/v1/query';
        
        $response = Http::withToken($accessToken)
            ->post($url, [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId
            ]);
        
        if ($response->successful()) {
            $result = $response->json();
            $resultCode = $result['ResultCode'] ?? null;
            
            if ($resultCode === 0) {
                // Payment was successful
                $wallet = $this->getWallet();
                $wallet->ksh_balance += $transaction->amount;
                $wallet->save();
                
                $transaction->status = 'completed';
                $transaction->balance_after = $wallet->ksh_balance;
                $transaction->meta = json_encode(array_merge(
                    json_decode($transaction->meta, true),
                    ['result' => $result]
                ));
                $transaction->save();
                
                session()->forget(['mpesa_checkout_id', 'mpesa_transaction_id']);
                return redirect()->route('wallet.index')->with('success', 'Your deposit of KSh' . number_format($transaction->amount, 2) . ' was successful.');
            } else {
                // Payment failed or pending
                if ($resultCode == 1032) {
                    // Transaction cancelled
                    $transaction->status = Transaction::STATUS_CANCELLED;
                    $transaction->meta = json_encode(array_merge(
                        json_decode($transaction->meta, true),
                        ['result' => $result]
                    ));
                    $transaction->save();
                    
                    session()->forget(['mpesa_checkout_id', 'mpesa_transaction_id']);
                    return redirect()->route('wallet.deposit.form')
                        ->with('error', 'The M-Pesa transaction was cancelled or timed out.');
                }
                
                // Still pending or other status
                return view('wallet.mpesa-status', [
                    'transaction' => $transaction,
                    'status' => 'pending',
                    'message' => 'Your payment is being processed. Please wait...',
                    'refresh' => true
                ]);
            }
        }
        
        Log::error('M-Pesa status check failed: ' . $response->body());
        return view('wallet.mpesa-status', [
            'transaction' => $transaction,
            'status' => 'unknown',
            'message' => 'Unable to determine payment status. Please check your M-Pesa messages to confirm.'
        ]);
    }

    /**
     * Callback URL for M-Pesa
     */
    public function callback(Request $request)
    {
        Log::info('M-Pesa callback received: ' . json_encode($request->all()));
        
        $callbackData = $request->json()->all();
        $resultCode = $callbackData['Body']['stkCallback']['ResultCode'] ?? null;
        $checkoutRequestId = $callbackData['Body']['stkCallback']['CheckoutRequestID'] ?? null;
        
        if (!$checkoutRequestId) {
            return response()->json(['success' => false]);
        }
        
        $transaction = Transaction::where('transaction_id', $checkoutRequestId)->first();
        if (!$transaction) {
            Log::error('M-Pesa transaction not found for CheckoutRequestID: ' . $checkoutRequestId);
            return response()->json(['success' => false]);
        }
        
        if ($resultCode === 0) {
            // Transaction successful
            $wallet = Wallet::find($transaction->wallet_id);
            if (!$wallet) {
                Log::error('Wallet not found for transaction: ' . $transaction->id);
                return response()->json(['success' => false]);
            }
            
            $wallet->ksh_balance += $transaction->amount;
            $wallet->save();
            
            $transaction->status = 'completed';
            $transaction->balance_after = $wallet->ksh_balance;
            $transaction->meta = json_encode(array_merge(
                json_decode($transaction->meta, true),
                ['callback_data' => $callbackData]
            ));
            $transaction->save();
            
            return response()->json(['success' => true]);
        } else {
            // Transaction failed
            $transaction->status = 'failed';
            $transaction->meta = json_encode(array_merge(
                json_decode($transaction->meta, true),
                ['callback_data' => $callbackData]
            ));
            $transaction->save();
            
            return response()->json(['success' => true]);
        }
    }

    /**
     * Get the authenticated user's wallet
     */
    private function getWallet()
    {
        $userId = Auth::id();
        return Wallet::where('user_id', $userId)->first();
    }
}
