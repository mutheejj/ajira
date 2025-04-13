<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the user's wallet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get or create wallet for user
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0.00]
        );
        
        // Get recent transactions
        $recentTransactions = Transaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Calculate stats
        $monthlyIncome = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
            
        $pendingWithdrawals = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'withdrawal')
            ->where('status', 'pending')
            ->sum('amount');
            
        // Get user's role for conditional display
        $isClient = $user->is_client;
        $isJobSeeker = $user->isJobSeeker();
        $isAdmin = $user->is_admin;
        
        return view('wallet.index', compact(
            'wallet', 
            'recentTransactions', 
            'monthlyIncome', 
            'pendingWithdrawals',
            'isClient',
            'isJobSeeker',
            'isAdmin'
        ));
    }
    
    /**
     * Display the user's transaction history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function transactions(Request $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        $query = Transaction::where('wallet_id', $wallet->id);
        
        // Filter by transaction type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        // Filter by date range
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }
        
        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('wallet.transactions', compact('wallet', 'transactions'));
    }
    
    /**
     * Process a deposit request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:10000',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
        ]);
        
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        try {
            DB::beginTransaction();
            
            // In a real app, you would process the payment through a payment gateway here
            // For demo purposes, we'll just create the transaction
            
            // Create transaction record
            $transaction = new Transaction();
            $transaction->wallet_id = $wallet->id;
            $transaction->amount = $request->amount;
            $transaction->type = 'deposit';
            $transaction->status = 'completed'; // Auto-complete for demo
            $transaction->description = 'Deposit via ' . ucfirst(str_replace('_', ' ', $request->payment_method));
            $transaction->reference = 'DEP-' . time();
            $transaction->save();
            
            // Update wallet balance
            $wallet->balance += $request->amount;
            $wallet->save();
            
            DB::commit();
            
            return redirect()->route('wallet.index')
                ->with('success', 'Deposit of $' . number_format($request->amount, 2) . ' was successful.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('wallet.index')
                ->with('error', 'An error occurred while processing your deposit. Please try again.');
        }
    }
    
    /**
     * Process a withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        // Validate common fields
        $validationRules = [
            'amount' => 'required|numeric|min:10|max:' . $wallet->balance,
            'withdrawal_method' => 'required|string|in:bank_account,paypal,mpesa,wise,payoneer,skrill,western_union',
        ];
        
        // Add specific validation rules based on the withdrawal method
        if ($request->withdrawal_method === 'mpesa') {
            $validationRules['mpesa_phone'] = 'required|regex:/^(254)[0-9]{9}$/';
            $validationRules['account_details'] = 'nullable|string|max:255';
        } else {
            $validationRules['account_details'] = 'required|string|max:255';
        }
        
        $request->validate($validationRules);
        
        try {
            DB::beginTransaction();
            
            // Prepare metadata based on withdrawal method
            $metaData = [
                'method' => $request->withdrawal_method
            ];
            
            if ($request->withdrawal_method === 'mpesa') {
                $metaData['phone_number'] = $request->mpesa_phone;
                $metaData['notes'] = $request->account_details;
            } else {
                $metaData['account_details'] = $request->account_details;
            }
            
            // Create transaction record
            $transaction = new Transaction();
            $transaction->wallet_id = $wallet->id;
            $transaction->amount = $request->amount;
            $transaction->type = 'withdrawal';
            $transaction->status = 'pending'; // Pending until admin approval or processing
            $transaction->description = 'Withdrawal via ' . ucfirst(str_replace('_', ' ', $request->withdrawal_method));
            $transaction->reference = 'WIT-' . time();
            $transaction->meta = json_encode($metaData);
            $transaction->save();
            
            // Update wallet balance (reserved amount)
            $wallet->reserved_balance += $request->amount;
            $wallet->save();
            
            // If MPesa selected, we could initiate the MPesa withdrawal here
            // This would involve calling the Daraja API
            // For simplicity, we're just setting up the transaction now
            
            DB::commit();
            
            return redirect()->route('wallet.index')
                ->with('success', 'Withdrawal request of $' . number_format($request->amount, 2) . ' has been submitted and is pending processing.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('wallet.index')
                ->with('error', 'An error occurred while processing your withdrawal request. Please try again. ' . $e->getMessage());
        }
    }
} 