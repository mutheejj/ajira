<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home and public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Static pages
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/how-to-hire', [PageController::class, 'howToHire'])->name('how-to-hire');
Route::get('/talent-marketplace', [PageController::class, 'talentMarketplace'])->name('talent-marketplace');
Route::get('/project-catalog', [PageController::class, 'projectCatalog'])->name('project-catalog');
Route::get('/hire-agency', [PageController::class, 'hireAgency'])->name('hire-agency');
Route::get('/enterprise', [PageController::class, 'enterprise'])->name('enterprise');
Route::get('/business-plus', [PageController::class, 'businessPlus'])->name('business-plus');
Route::get('/any-hire', [PageController::class, 'anyHire'])->name('any-hire');
Route::get('/contract-to-hire', [PageController::class, 'contractToHire'])->name('contract-to-hire');
Route::get('/hire-worldwide', [PageController::class, 'hireWorldwide'])->name('hire-worldwide');
Route::get('/hire-us', [PageController::class, 'hireUs'])->name('hire-us');
Route::get('/how-to-find-work', [PageController::class, 'howToFindWork'])->name('how-to-find-work');
Route::get('/direct-contracts', [PageController::class, 'directContracts'])->name('direct-contracts');
Route::get('/direct-contracts-talent', [PageController::class, 'directContractsTalent'])->name('direct-contracts-talent');
Route::get('/find-jobs-worldwide', [PageController::class, 'findJobsWorldwide'])->name('find-jobs-worldwide');
Route::get('/find-jobs-usa', [PageController::class, 'findJobsUsa'])->name('find-jobs-usa');
Route::get('/win-work-ads', [PageController::class, 'winWorkAds'])->name('win-work-ads');
Route::get('/freelancer-plus', [PageController::class, 'freelancerPlus'])->name('freelancer-plus');
Route::get('/worldwide-jobs', [PageController::class, 'worldwideJobs'])->name('worldwide-jobs');
Route::get('/local-jobs', [PageController::class, 'localJobs'])->name('local-jobs');
Route::get('/help-support', [PageController::class, 'helpSupport'])->name('help-support');
Route::get('/success-stories', [PageController::class, 'successStories'])->name('success-stories');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/resources', [PageController::class, 'resources'])->name('resources');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/affiliate', [PageController::class, 'affiliate'])->name('affiliate');
Route::get('/free-tools', [PageController::class, 'freeTools'])->name('free-tools');
Route::get('/leadership', [PageController::class, 'leadership'])->name('leadership');
Route::get('/investor-relations', [PageController::class, 'investorRelations'])->name('investor-relations');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::get('/our-impact', [PageController::class, 'ourImpact'])->name('our-impact');
Route::get('/press', [PageController::class, 'press'])->name('press');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/partners', [PageController::class, 'partners'])->name('partners');
Route::get('/trust-safety', [PageController::class, 'trustSafety'])->name('trust-safety');
Route::get('/modern-slavery', [PageController::class, 'modernSlavery'])->name('modern-slavery');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/ca-notice', [PageController::class, 'caNotice'])->name('ca-notice');
Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/learn-more', [PageController::class, 'learnMore'])->name('learn-more');

// Authentication routes
// Auth::routes(['verify' => true]);

// Custom Authentication Routes
Route::group(['middleware' => 'guest'], function () {
    // Register
    Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
    
    // Login
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    
    // Password Reset
    Route::get('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'sendResetPasswordLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\AuthController::class, 'resetPassword'])->name('password.update');
});

// Authentication Required Routes
Route::middleware(['auth'])->group(function () {
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Logout
    Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
    
    // Email Verification
    Route::get('/email/verify', [App\Http\Controllers\Auth\AuthController::class, 'showVerificationNotice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\AuthController::class, 'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [App\Http\Controllers\Auth\AuthController::class, 'resendVerificationEmail'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');
        
    // General dashboard route
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    
    // Client dashboard
    Route::middleware(['client'])->group(function () {
        Route::get('/client/dashboard', [App\Http\Controllers\HomeController::class, 'clientDashboard'])->name('client.dashboard');
        Route::get('/client/jobs', [JobPostController::class, 'clientJobs'])->name('client.jobs');
        Route::get('/client/jobs/create', [JobPostController::class, 'create'])->name('client.jobs.create');
        Route::post('/client/jobs', [JobPostController::class, 'store'])->name('client.jobs.store');
        Route::get('/client/jobs/{jobPost}/edit', [JobPostController::class, 'edit'])->name('client.jobs.edit');
        Route::put('/client/jobs/{jobPost}', [JobPostController::class, 'update'])->name('client.jobs.update');
        Route::delete('/client/jobs/{jobPost}', [JobPostController::class, 'destroy'])->name('client.jobs.destroy');
    });
    
    // Job seeker dashboard
    Route::middleware(['job-seeker'])->group(function () {
        Route::get('/jobseeker/dashboard', [HomeController::class, 'jobseekerDashboard'])->name('jobseeker.dashboard');
        Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
        Route::get('/jobs/{jobId}/apply', [JobApplicationController::class, 'create'])->name('applications.create');
        Route::post('/jobs/{jobId}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
        Route::delete('/applications/{id}/withdraw', [JobApplicationController::class, 'withdraw'])->name('applications.withdraw');
        
        // Saved jobs
        Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
        Route::post('/jobs/{jobId}/save', [SavedJobController::class, 'store'])->name('saved-jobs.store');
        Route::delete('/saved-jobs/{id}', [SavedJobController::class, 'destroy'])->name('saved-jobs.destroy');
    });
    
    // Admin dashboard
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    });

    // Application routes
    Route::get('/jobs/{jobId}/apply', [App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{jobId}/applications', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{id}', [App\Http\Controllers\ApplicationController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{id}/status', [App\Http\Controllers\ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    Route::patch('/applications/{id}/withdraw', [App\Http\Controllers\ApplicationController::class, 'withdraw'])->name('applications.withdraw');
    Route::get('/jobs/{jobId}/applications', [App\Http\Controllers\ApplicationController::class, 'listByJob'])->name('applications.list');
    Route::get('/my-applications', [App\Http\Controllers\ApplicationController::class, 'myApplications'])->name('applications.my');
    Route::get('/applications/{id}/download', [App\Http\Controllers\ApplicationController::class, 'downloadAttachment'])->name('applications.download');
});

// Job posts
Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobPostController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');
Route::get('/post-job', [JobPostController::class, 'create'])->name('post-job');

// Freelancers
Route::get('/freelancers', [FreelancerController::class, 'index'])->name('freelancer.index');
Route::get('/freelancers/{freelancer}', [FreelancerController::class, 'show'])->name('freelancer.show');

// Companies
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

// Client Routes
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/jobs', [ClientController::class, 'jobs'])->name('jobs');
    Route::get('/create-job', [ClientController::class, 'createJob'])->name('create-job');
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ClientController::class, 'updateProfile'])->name('update-profile');
    Route::get('/billing', [ClientController::class, 'billing'])->name('billing');
    Route::get('/email-verification', [ClientController::class, 'emailVerification'])->name('verify-email');
});
