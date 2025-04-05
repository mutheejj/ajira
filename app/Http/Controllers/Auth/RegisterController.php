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

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

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
        // $this->sendVerificationEmail($user, $verification->code);

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

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectTo);
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
        // Implementation for sending verification email
        // Will be implemented later
    }
} 