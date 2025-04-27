<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobSeekerWalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:job_seeker']);
    }
    
    /**
     * Display the wallet dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get or create wallet
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 200.00,  // Default starting balance
                'currency' => 'USD'
            ]
        );
        
        // Get recent transactions
        $transactions = Transaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get stats
        $stats = [
            'total_earned' => Transaction::where('wallet_id', $wallet->id)
                ->where('type', 'payment')
                ->where('status', 'completed')
                ->sum('amount'),
            'pending_payments' => Transaction::where('wallet_id', $wallet->id)
                ->where('type', 'payment')
                ->where('status', 'pending')
                ->sum('amount'),
            'total_withdrawn' => Transaction::where('wallet_id', $wallet->id)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->sum('amount'),
        ];
            
        return view('job-seeker.wallet.index', compact('wallet', 'transactions', 'stats'));
    }
    
    /**
     * Display transaction history.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function transactions(Request $request)
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        $query = Transaction::where('wallet_id', $wallet->id);
        
        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('job-seeker.wallet.transactions', compact('wallet', 'transactions'));
    }
    
    /**
     * Show the form for requesting a withdrawal.
     *
     * @return \Illuminate\Http\Response
     */
    public function showWithdrawalForm()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        // Get available payment methods (placeholder for now)
        $paymentMethods = [
            'bank_transfer' => 'Bank Transfer',
            'paypal' => 'PayPal',
            'mobile_money' => 'Mobile Money'
        ];
        
        return view('job-seeker.wallet.withdrawal', compact('wallet', 'paymentMethods'));
    }
    
    /**
     * Process a withdrawal request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|string',
            'payment_details' => 'required|string'
        ]);
        
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        // Check if user has sufficient balance
        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient funds for this withdrawal');
        }
        
        try {
            DB::beginTransaction();
            
            // Create a pending withdrawal transaction
            $transaction = new Transaction([
                'wallet_id' => $wallet->id,
                'amount' => -$request->amount, // Negative amount for withdrawal
                'type' => 'withdrawal',
                'status' => 'pending',
                'description' => 'Withdrawal request via ' . $request->payment_method,
                'metadata' => [
                    'payment_method' => $request->payment_method,
                    'payment_details' => $request->payment_details
                ]
            ]);
            
            $transaction->save();
            
            // Reserve the amount in the wallet
            $wallet->reserved_balance += $request->amount;
            $wallet->save();
            
            DB::commit();
            
            // Notify admin about the withdrawal request (would implement email notification here)
            
            return redirect()->route('job-seeker.wallet.index')
                ->with('success', 'Withdrawal request submitted successfully and is pending approval');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    /**
     * Display withdrawal history.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawals()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        $withdrawals = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'withdrawal')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('job-seeker.wallet.withdrawals', compact('wallet', 'withdrawals'));
    }
}
