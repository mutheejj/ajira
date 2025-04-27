<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class FixJobPostsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job-posts:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the job_posts table specifically';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking job_posts table...');
        
        // Check if job_posts table exists
        if (Schema::hasTable('job_posts')) {
            $this->info('job_posts table already exists.');
            return Command::SUCCESS;
        }
        
        $this->warn('job_posts table does not exist. Attempting to create it...');
        
        // Check if users table exists (dependency)
        if (!Schema::hasTable('users')) {
            $this->error('users table does not exist. This is a dependency for job_posts.');
            $this->info('Please run php artisan migrations:fix --reset to fix all migrations.');
            return Command::FAILURE;
        }
        
        // Attempt to run the job_posts migration
        $this->info('Running job_posts table migration...');
        
        try {
            Artisan::call('migrate', [
                '--path' => "database/migrations/2025_08_02_01_000001_create_job_posts_table.php",
                '--force' => true,
            ]);
            $this->info(Artisan::output());
            
            // Now check if there are related migrations for job_posts
            $relatedMigrations = [
                '2025_15_02_20_000001_create_job_post_skill_table.php',
                '2025_18_04_06_000001_update_job_posts_table.php',
                '2025_19_01_01_000001_add_application_deadline_to_job_posts.php',
            ];
            
            foreach ($relatedMigrations as $migration) {
                $this->info("Running related migration: {$migration}");
                try {
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$migration}",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                } catch (\Exception $e) {
                    $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                    // Continue with other migrations
                }
            }
            
            $this->info('job_posts table created successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to create job_posts table: " . $e->getMessage());
            $this->info('For a more comprehensive fix, please run php artisan migrations:fix --reset');
            return Command::FAILURE;
        }
    }
}
