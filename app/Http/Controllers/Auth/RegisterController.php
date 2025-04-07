<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verify-email';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', 'in:client,job-seeker'],
        ];

        // Add validation rules based on user type
        if ($data['user_type'] === 'client') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['industry'] = ['required', 'string', 'max:255'];
            $rules['company_size'] = ['required', 'string', 'max:100'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],
        ];

        // Add user type specific fields
        if ($data['user_type'] === 'client') {
            $userData = array_merge($userData, [
                'company_name' => $data['company_name'],
                'industry' => $data['industry'],
                'company_size' => $data['company_size'],
                'website' => $data['website'] ?? null,
                'description' => $data['description'] ?? null,
            ]);
        } elseif ($data['user_type'] === 'job-seeker') {
            $userData = array_merge($userData, [
                'profession' => $data['profession'] ?? null,
                'experience' => $data['experience'] ?? null,
                'skills' => isset($data['skills']) ? json_decode($data['skills']) : null,
                'bio' => $data['bio'] ?? null,
            ]);
        }

        $user = User::create($userData);

        // Create email verification code
        $verification = new EmailVerification([
            'user_id' => $user->id,
            'expires_at' => now()->addHours(24),
        ]);
        $verification->save();

        // Send verification email
        $this->sendVerificationEmail($user, $verification->code);

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // Don't auto-login the user - must verify email first
        // Instead, redirect to the verification page
        \Log::info('User registered successfully: ' . $user->email);
        
        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email for verification code.')
            ->with('email', $user->email); // Pass email to the verification page
    }

    /**
     * Send the email verification notification.
     *
     * @param  User  $user
     * @param  string  $code
     * @return void
     */
    protected function sendVerificationEmail(User $user, $code)
    {
        try {
            $data = [
                'user' => $user,
                'code' => $code
            ];
            
            Mail::send('emails.verification', $data, function($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Verify Your Email Address');
            });
            
            // Log successful email send
            \Log::info('Verification email sent to: ' . $user->email);
        } catch (\Exception $e) {
            // Log any errors that occur
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the email verification form.
     */
    public function showVerificationForm()
    {
        return view('auth.verify-email');
    }
    
    /**
     * Verify user's email with the provided code.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }
        
        $verification = EmailVerification::where('user_id', $user->id)
            ->where('code', $request->code)
            ->first();
            
        if (!$verification) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }
        
        if ($verification->hasExpired()) {
            return back()->withErrors(['code' => 'Verification code has expired.']);
        }
        
        // Mark email as verified
        $user->email_verified_at = now();
        $user->save();
        
        // Delete the verification code
        $verification->delete();
        
        // Log the user in
        auth()->login($user);
        
        // Redirect based on user type
        if ($user->isClient()) {
            return redirect()->route('client.dashboard')
                ->with('success', 'Email verified successfully!');
        } else {
            return redirect()->route('jobseeker.dashboard')
                ->with('success', 'Email verified successfully!');
        }
    }
    
    /**
     * Resend verification code to the user.
     */
    public function resendVerification(Request $request)
    {
        // Get email from request or query string
        $email = $request->input('email') ?? $request->query('email');
        
        if (!$email) {
            return back()->withErrors(['email' => 'Email address is required.']);
        }
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'This email address is not registered in our system.'
        ]);
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }
        
        // If user is already verified
        if ($user->email_verified_at) {
            return redirect()->route('login')
                ->with('info', 'Your email is already verified. Please login.');
        }
        
        // Delete existing verification code
        if ($user->emailVerification) {
            $user->emailVerification->delete();
        }
        
        // Create new verification code
        $verification = new EmailVerification([
            'user_id' => $user->id,
            'expires_at' => now()->addHours(24),
        ]);
        $verification->save();
        
        // Send new verification code
        $this->sendVerificationEmail($user, $verification->code);
        
        return redirect()->route('verification.notice')
            ->with('success', 'A new verification code has been sent to your email.')
            ->with('email', $email);
    }
} 