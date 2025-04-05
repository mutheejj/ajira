<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    /**
     * Show the register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', 'in:client,job-seeker'],
            
            // Conditional validation for client
            'company_name' => ['required_if:user_type,client', 'nullable', 'string', 'max:255'],
            'industry' => ['required_if:user_type,client', 'nullable', 'string', 'max:255'],
            'company_size' => ['required_if:user_type,client', 'nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            
            // Conditional validation for job seeker
            'profession' => ['required_if:user_type,job-seeker', 'nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => $request->user_type,
        ];

        // Add user type specific fields
        if ($request->user_type === 'client') {
            $userData = array_merge($userData, [
                'company_name' => $request->company_name,
                'industry' => $request->industry,
                'company_size' => $request->company_size,
                'website' => $request->website ?? null,
                'description' => $request->description ?? null,
            ]);
        } elseif ($request->user_type === 'job-seeker') {
            // Process skills as a JSON array
            $skills = null;
            if ($request->skills) {
                $skillsArray = array_map('trim', explode(',', $request->skills));
                $skills = json_encode($skillsArray);
            }

            $userData = array_merge($userData, [
                'profession' => $request->profession ?? null,
                'experience' => $request->experience ?? null,
                'skills' => $skills,
                'bio' => $request->bio ?? null,
            ]);
        }

        $user = User::create($userData);

        // Trigger registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect to appropriate dashboard based on user type
        if ($user->user_type === 'client') {
            return redirect()->route('client.dashboard')->with('success', 'Account created successfully! Please check your email to verify your account.');
        } else {
            return redirect()->route('job-seeker.dashboard')->with('success', 'Account created successfully! Please check your email to verify your account.');
        }
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on user type
            if ($user->user_type === 'client') {
                return redirect()->intended(route('client.dashboard'));
            } elseif ($user->user_type === 'job-seeker') {
                return redirect()->intended(route('job-seeker.dashboard'));
            } elseif ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // Default redirect
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Show the email verification notice
     */
    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    /**
     * Handle email verification
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = Auth::user();
        if ($user->user_type === 'client') {
            return redirect()->route('client.dashboard')->with('success', 'Email verified successfully!');
        } else {
            return redirect()->route('job-seeker.dashboard')->with('success', 'Email verified successfully!');
        }
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send reset password link
     */
    public function sendResetPasswordLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
} 