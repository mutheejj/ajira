<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        $wallet = $this->getOrCreateWallet();
        $transactions = Transaction::where('wallet_id', $wallet->id)
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
        $user = Auth::user();
        $isClient = $user->is_client;
        $isJobSeeker = $user->isJobSeeker();
        $isAdmin = $user->is_admin;
        
        return view('wallet.index', compact(
            'wallet', 
            'transactions', 
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
        $wallet = $this->getOrCreateWallet();
        
        $query = Transaction::where('wallet_id', $wallet->id);
        
        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('wallet.transactions', compact('wallet', 'transactions'));
    }
    
    /**
     * Show deposit form
     */
    public function showDepositForm()
    {
        $wallet = $this->getOrCreateWallet();
        return view('wallet.deposit', compact('wallet'));
    }
    
    /**
     * Process deposit
     */
    public function processDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:card,bank,ussd',
            'currency' => 'required|in:USD,KSH',
        ]);
        
        // For demo, we'll just add the money directly
        // In a real application, you would integrate with a payment gateway
        
        $wallet = $this->getOrCreateWallet();
        $amount = $request->amount;
        $currency = $request->currency;
        
        DB::beginTransaction();
        
        try {
            // Update wallet balance based on currency
            if ($currency == 'USD') {
                $oldBalance = $wallet->usd_balance;
                $wallet->usd_balance += $amount;
            } else if ($currency == 'KSH') {
                $oldBalance = $wallet->ksh_balance;
                $wallet->ksh_balance += $amount;
            }
            $wallet->save();
            
            // Create transaction record
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => 'deposit',
                'description' => 'Funds deposit',
                'reference' => 'DEP-' . Str::random(10),
                'status' => 'completed',
                'currency' => $currency,
                'meta' => json_encode([
                    'payment_method' => $request->payment_method
                ])
            ]);
            
            DB::commit();
            
            $formattedAmount = $currency == 'USD' ? '$' . number_format($amount, 2) : 'KSh' . number_format($amount, 2);
            return redirect()->route('wallet.index')
                ->with('success', "{$formattedAmount} has been successfully added to your wallet");
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to process your deposit: ' . $e->getMessage());
        }
    }
    
    /**
     * Show withdrawal form
     */
    public function showWithdrawForm()
    {
        $wallet = $this->getOrCreateWallet();
        return view('wallet.withdraw', compact('wallet'));
    }
    
    /**
     * Process withdrawal
     */
    public function processWithdrawal(Request $request)
    {
        $wallet = $this->getOrCreateWallet();
        
        $request->validate([
            'amount' => 'required|numeric|min:5',
            'bank_name' => 'required|string',
            'account_number' => 'required|string|size:10',
            'account_name' => 'required|string',
            'currency' => 'required|in:USD,KSH',
        ]);
        
        $amount = $request->amount;
        $currency = $request->currency;
        
        // Validate sufficient balance based on currency
        if ($currency == 'USD' && $wallet->usd_balance < $amount) {
            return back()->with('error', 'Insufficient USD balance for withdrawal.');
        } else if ($currency == 'KSH' && $wallet->ksh_balance < $amount) {
            return back()->with('error', 'Insufficient KSH balance for withdrawal.');
        }
        
        DB::beginTransaction();
        
        try {
            // Update wallet balance based on currency
            if ($currency == 'USD') {
                $oldBalance = $wallet->usd_balance;
                $wallet->usd_balance -= $amount;
            } else if ($currency == 'KSH') {
                $oldBalance = $wallet->ksh_balance;
                $wallet->ksh_balance -= $amount;
            }
            $wallet->save();
            
            // Create transaction record
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => 'withdrawal',
                'description' => 'Funds withdrawal to bank account',
                'reference' => 'WTH-' . Str::random(10),
                'status' => 'completed',
                'currency' => $currency,
                'meta' => json_encode([
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name
                ])
            ]);
            
            DB::commit();
            
            $formattedAmount = $currency == 'USD' ? '$' . number_format($amount, 2) : 'KSh' . number_format($amount, 2);
            return redirect()->route('wallet.index')
                ->with('success', "{$formattedAmount} has been successfully withdrawn from your wallet");
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to process your withdrawal: ' . $e->getMessage());
        }
    }
    
    /**
     * Process payment for a task
     */
    public function processTaskPayment(Request $request, Task $task)
    {
        $user = Auth::user();
        
        if (!$user->is_client) {
            return back()->with('error', 'Only clients can make payments.');
        }
        
        if ($task->client_id !== $user->id) {
            return back()->with('error', 'You are not authorized to make payment for this task.');
        }
        
        if (!in_array($task->status, [Task::STATUS_COMPLETED, Task::STATUS_SUBMITTED])) {
            return back()->with('error', 'Payment can only be made for completed tasks.');
        }
        
        $amount = $task->budget;
        $wallet = $this->getOrCreateWallet();
        
        if ($wallet->usd_balance < $amount) {
            return back()->with('error', 'Insufficient funds in your wallet. Please deposit more funds.');
        }
        
        DB::beginTransaction();
        
        try {
            // Deduct from client's wallet
            $wallet->usd_balance -= $amount;
            $wallet->save();
            
            // Record the payment transaction
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => 'payment',
                'description' => "Payment for task: {$task->title}",
                'reference' => 'PAY-' . Str::random(10),
                'status' => 'completed',
                'currency' => 'USD',
                'meta' => json_encode([
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'recipient_id' => $task->assigned_to
                ])
            ]);
            
            // Add to job seeker's wallet
            $jobSeekerWallet = Wallet::firstOrCreate(
                ['user_id' => $task->assigned_to],
                ['usd_balance' => 0]
            );
            
            $oldJobSeekerBalance = $jobSeekerWallet->usd_balance;
            $jobSeekerWallet->usd_balance += $amount;
            $jobSeekerWallet->save();
            
            // Record the received transaction for job seeker
            Transaction::create([
                'wallet_id' => $jobSeekerWallet->id,
                'amount' => $amount,
                'type' => 'received',
                'description' => "Payment received for task: {$task->title}",
                'reference' => 'REC-' . Str::random(10),
                'status' => 'completed',
                'currency' => 'USD',
                'meta' => json_encode([
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'sender_id' => $user->id
                ])
            ]);
            
            // Update task status to paid
            $task->status = Task::STATUS_PAID;
            $task->save();
            
            DB::commit();
            
            return back()->with('success', "Payment of $" . number_format($amount, 2) . " has been successfully made for this task.");
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Get the authenticated user's wallet or create it if it doesn't exist
     */
    private function getOrCreateWallet()
    {
        $userId = Auth::id();
        
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            [
                'balance' => 0,
                'currency' => 'USD',
                'usd_balance' => 200,  // Default starting balance for new wallets
                'ksh_balance' => 0
            ]
        );
        
        return $wallet;
    }
} 