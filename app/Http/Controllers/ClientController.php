<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'client']);
    }

    /**
     * Display client dashboard with relevant statistics and data.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Retrieve statistics
        $stats = [
            'active_jobs' => $user->jobPosts()->where('status', 'active')->count(),
            'total_jobs' => $user->jobPosts()->count(),
            'pending_applications' => 0, // Will be calculated below
            'active_contracts' => 0, // Placeholder for contracts feature
            'conversion_rate' => 0,
            'monthly_spending' => [] // Will be filled below
        ];
        
        // Get job posts with their application counts
        $jobPosts = $user->jobPosts()->latest()->limit(5)->get();
        
        // Calculate pending applications count and get recent applications
        $jobIds = $user->jobPosts()->pluck('id');
        $pendingApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)
            ->where('status', 'pending')
            ->count();
        $recentApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)
            ->with(['user', 'jobPost'])
            ->latest()
            ->limit(5)
            ->get();
        
        $stats['pending_applications'] = $pendingApplications;
        
        // Calculate applications per job count for conversion rate
        $totalApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)->count();
        if ($stats['total_jobs'] > 0) {
            $stats['conversion_rate'] = round(($totalApplications / $stats['total_jobs']) * 100);
        }
        
        // Get top freelancers (based on number of applications to client's jobs)
        $topFreelancers = \App\Models\User::whereHas('applications', function($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        })
        ->withCount(['applications' => function($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        }])
        ->orderBy('applications_count', 'desc')
        ->limit(5)
        ->get();
        
        // Generate monthly spending data for the chart (placeholder)
        $monthlySpending = [];
        
        // Generate labels for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M');
            $monthlySpending[$monthName] = rand(100, 5000); // Random placeholder data
        }
        
        $stats['monthly_spending'] = $monthlySpending;
        
        return view('client.dashboard', compact('user', 'stats', 'jobPosts', 'recentApplications', 'topFreelancers'));
    }
    
    /**
     * Display all jobs posted by the client.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function jobs(Request $request)
    {
        $user = auth()->user();
        
        // Prepare query with filters
        $query = $user->jobPosts();
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        $allowedSortFields = ['created_at', 'title', 'budget'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        
        $query->orderBy($sortBy, $sortDir);
        
        // Get jobs with application counts
        $jobs = $query->withCount(['applications', 'applications as accepted_applications_count' => function($query) {
            $query->where('status', 'accepted');
        }])->paginate(10);
        
        // Get status counts for filters
        $statusCounts = [
            'all' => $user->jobPosts()->count(),
            'active' => $user->jobPosts()->where('status', 'active')->count(),
            'completed' => $user->jobPosts()->where('status', 'completed')->count(),
            'draft' => $user->jobPosts()->where('status', 'draft')->count(),
            'closed' => $user->jobPosts()->where('status', 'closed')->count(),
        ];
        
        return view('client.jobs', compact('jobs', 'statusCounts'));
    }
    
    /**
     * Show the form for creating a new job post.
     *
     * @return \Illuminate\Http\Response
     */
    public function createJob()
    {
        try {
            // Get categories and skills for select dropdowns
            $categories = [];
            $skills = [];
            
            // Check if Category model exists
            if (class_exists('\App\Models\Category')) {
                $categories = \App\Models\Category::orderBy('name')->get();
            }
            
            // Check if Skill model exists
            if (class_exists('\App\Models\Skill')) {
                $skills = \App\Models\Skill::orderBy('name')->get();
            }
            
            \Log::info('Loading create job form with categories count: ' . count($categories) . ', skills count: ' . count($skills));
            
            return view('client.create-job', compact('categories', 'skills'));
        } catch (\Exception $e) {
            \Log::error('Error loading create job form: ' . $e->getMessage());
            // Return the view without the models if there's an error
            return view('client.create-job');
        }
    }
    
    /**
     * Store a new job post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeJob(Request $request)
    {
        \Log::info('Job post data received', ['data' => $request->except('attachment')]);
        
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:100',
                'category' => 'required|string',
                'description' => 'required|string|min:20',
                'skills' => 'required|array|min:1',
                'skills.*' => 'string',
                'budget' => 'required|numeric|min:5',
                'currency' => 'required|string|in:USD,KES,EUR,GBP',
                'rate_type' => 'required|string|in:fixed,hourly',
                'job_type' => 'required|string|in:one-time,ongoing',
                'experience_level' => 'required|string|in:entry,intermediate,expert',
                'location_type' => 'required|string|in:remote,on-site,hybrid',
                'location' => 'nullable|string|max:100',
                'attachment' => 'nullable|file|max:5120',
                'status' => 'nullable|string|in:draft,active',
            ]);
            
            \Log::info('Job post validation passed', ['skills' => $request->skills]);
            
            $client = Auth::user();
            
            if (!$client) {
                \Log::error('User not authenticated when trying to post a job');
                return redirect()->route('login')
                    ->with('error', 'You must be logged in to post a job');
            }
            
            $jobPost = new \App\Models\JobPost();
            $jobPost->client_id = $client->id;
            $jobPost->title = $request->title;
            $jobPost->category = $request->category;
            $jobPost->description = $request->description;
            
            // Ensure skills is properly encoded as JSON
            if (is_array($request->skills)) {
                $jobPost->skills = json_encode($request->skills);
                \Log::info('Skills encoded successfully', ['skills_count' => count($request->skills)]);
            } else {
                \Log::warning('Skills is not an array', ['skills' => $request->skills]);
                $jobPost->skills = json_encode([$request->skills]);
            }
            
            $jobPost->budget = $request->budget;
            $jobPost->currency = $request->currency;
            $jobPost->rate_type = $request->rate_type;
            $jobPost->job_type = $request->job_type;
            $jobPost->experience_level = $request->experience_level;
            $jobPost->location_type = $request->location_type;
            $jobPost->location = $request->location;
            $jobPost->status = $request->status ?? 'active';
            
            // Handle attachment if provided
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                try {
                    $path = $request->file('attachment')->store('job_attachments', 'public');
                    $jobPost->attachment = $path;
                    \Log::info('Attachment uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Error uploading attachment: ' . $e->getMessage());
                    // Continue without the attachment
                }
            }
            
            $jobPost->save();
            
            \Log::info('Job post created successfully', ['job_id' => $jobPost->id]);
            
            return redirect()->route('client.jobs')
                ->with('success', 'Job post created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error creating job post', [
                'errors' => $e->errors(),
                'input' => $request->except(['attachment'])
            ]);
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating job post: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['attachment'])
            ]);
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Show client profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        
        // Retrieve statistics
        $stats = [
            'active_jobs' => $user->jobPosts()->where('status', 'active')->count(),
            'total_jobs' => $user->jobPosts()->count(),
            'active_contracts' => 0, // Placeholder for contracts feature
            'hired_freelancers' => 0, // Placeholder
        ];
        
        // Get list of countries and industries for dropdowns
        $countries = $this->getCountriesList();
        $industries = $this->getIndustriesList();
        
        return view('client.profile', compact('user', 'stats', 'countries', 'industries'));
    }
    
    /**
     * Update client profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:5120', // 5MB max
        ]);
        
        // Process profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
        
        $user->update($validated);
        
        return redirect()->route('client.profile')->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Show billing and payment methods page.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing()
    {
        $user = auth()->user();
        
        // Placeholder data for payment methods
        $paymentMethods = collect([
            (object)[
                'id' => 1,
                'type' => 'credit_card',
                'name' => 'Visa ending in 4242',
                'last4' => '4242',
                'exp_month' => '12',
                'exp_year' => '2025',
                'is_default' => true
            ],
            (object)[
                'type' => 'paypal',
                'name' => 'PayPal',
                'email' => $user->email,
                'is_default' => false
            ]
        ]);
        
        // Placeholder data for transactions
        $transactions = collect([
            (object)[
                'id' => 'inv_123456',
                'description' => 'Pro Subscription',
                'date' => now()->subDays(2),
                'amount' => 49.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'subscription',
                'plan' => 'Pro'
            ],
            (object)[
                'id' => 'inv_123455',
                'description' => 'Featured Job Listing',
                'date' => now()->subDays(15),
                'amount' => 29.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'payment',
                'item' => 'Job Boost'
            ],
            (object)[
                'id' => 'inv_123454',
                'description' => 'Pro Subscription',
                'date' => now()->subDays(32),
                'amount' => 49.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'subscription',
                'plan' => 'Pro'
            ]
        ]);
        
        // Placeholder for billing address
        $billingAddress = (object)[
            'name' => $user->name,
            'address_line1' => '123 Business Ave',
            'address_line2' => 'Suite 101',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postal_code' => '94107',
            'country' => 'United States'
        ];
        
        // Current subscription plan
        $currentPlan = 'pro';
        
        return view('client.billing', compact('user', 'paymentMethods', 'transactions', 'billingAddress', 'currentPlan'));
    }
    
    /**
     * Show email verification page.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail()
    {
        $user = Auth::user();
        
        return view('client.email-verification', compact('user'));
    }
    
    /**
     * Resend verification email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        
        return back()->with('success', 'Verification link has been sent to your email address.');
    }

    /**
     * Get a list of countries for dropdowns.
     */
    private function getCountriesList()
    {
        return [
            'United States', 'United Kingdom', 'Canada', 'Australia', 
            'Germany', 'France', 'Spain', 'Italy', 'Netherlands',
            'Sweden', 'Norway', 'Denmark', 'Finland', 'Ireland',
            'Belgium', 'Switzerland', 'Austria', 'Portugal', 'Greece',
            'Poland', 'Czech Republic', 'Hungary', 'Romania', 'Bulgaria',
            'Croatia', 'Slovakia', 'Slovenia', 'Estonia', 'Latvia',
            'Lithuania', 'Luxembourg', 'Malta', 'Cyprus', 'Iceland',
            'India', 'China', 'Japan', 'South Korea', 'Singapore',
            'Malaysia', 'Indonesia', 'Thailand', 'Vietnam', 'Philippines',
            'Brazil', 'Mexico', 'Argentina', 'Chile', 'Colombia',
            'Peru', 'South Africa', 'Nigeria', 'Kenya', 'Egypt',
            'Morocco', 'Israel', 'United Arab Emirates', 'Saudi Arabia',
            'New Zealand', 'Russia', 'Ukraine', 'Turkey'
        ];
    }

    /**
     * Get a list of industries for dropdowns.
     */
    private function getIndustriesList()
    {
        return [
            'Technology', 'Software Development', 'Information Technology', 
            'E-commerce', 'Digital Marketing', 'Design', 'Healthcare', 
            'Finance', 'Education', 'Manufacturing', 'Retail', 
            'Transportation', 'Hospitality', 'Media', 'Entertainment', 
            'Real Estate', 'Construction', 'Agriculture', 'Energy', 
            'Environmental Services', 'Non-profit', 'Government', 
            'Legal Services', 'Consulting', 'Human Resources', 
            'Telecommunications', 'Automotive', 'Aerospace', 
            'Biotechnology', 'Pharmaceuticals', 'Food & Beverage'
        ];
    }
} 