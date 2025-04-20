<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Task;
use App\Models\User;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DummyTaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'job-seeker']);
    }
    
    /**
     * Create dummy tasks for the job seeker for demonstration purposes.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createDummyTasks()
    {
        $user = Auth::user();
        
        // Find or create a dummy client
        $client = User::firstOrCreate(
            ['email' => 'demo.client@ajira.com'],
            [
                'name' => 'Demo Client',
                'password' => bcrypt('password'),
                'user_type' => 'client',
                'email_verified_at' => now(),
            ]
        );
        
        // Create or find a demo job post
        $jobPost = JobPost::firstOrCreate(
            ['title' => 'Demo Web Development Project'],
            [
                'client_id' => $client->id,
                'description' => 'This is a demo job post for web development tasks.',
                'requirements' => 'Experience with PHP, Laravel, JavaScript, and frontend frameworks.',
                'budget' => 1000.00,
                'duration' => '2 weeks',
                'status' => 'active',
                'category' => 'Web Development',
                'location' => 'Remote',
                'posted_at' => now(),
            ]
        );
        
        // Create a contract
        $contract = Contract::create([
            'job_id' => $jobPost->id,
            'job_seeker_id' => $user->id,
            'client_id' => $client->id,
            'title' => $jobPost->title,
            'description' => $jobPost->description,
            'amount' => $jobPost->budget,
            'currency' => 'USD',
            'status' => 'in_progress',
            'start_date' => now(),
            'end_date' => now()->addDays(14),
        ]);
        
        // Create demo tasks
        $tasks = [
            [
                'title' => 'Design User Interface',
                'description' => 'Create wireframes and mockups for the web application interface.',
                'priority' => 'high',
                'due_date' => now()->addDays(3),
                'status' => 'in_progress',
                'progress' => 75,
            ],
            [
                'title' => 'Implement Frontend Components',
                'description' => 'Develop responsive UI components using React and Tailwind CSS.',
                'priority' => 'medium',
                'due_date' => now()->addDays(7),
                'status' => 'pending',
                'progress' => 0,
            ],
            [
                'title' => 'Backend API Development',
                'description' => 'Create RESTful APIs for the web application using Laravel.',
                'priority' => 'medium',
                'due_date' => now()->addDays(10),
                'status' => 'pending',
                'progress' => 0,
            ],
            [
                'title' => 'Integration Testing',
                'description' => 'Write and perform integration tests for all application components.',
                'priority' => 'low',
                'due_date' => now()->addDays(12),
                'status' => 'pending',
                'progress' => 0,
            ],
            [
                'title' => 'Deployment and Documentation',
                'description' => 'Deploy the application and create user and technical documentation.',
                'priority' => 'low',
                'due_date' => now()->addDays(14),
                'status' => 'pending',
                'progress' => 0,
            ],
        ];
        
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, ['contract_id' => $contract->id]));
        }
        
        return redirect()->route('jobseeker.tasks')
            ->with('success', 'Demo tasks created successfully!');
    }
} 