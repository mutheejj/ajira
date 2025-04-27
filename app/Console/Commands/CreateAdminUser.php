<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--fix-migrations : Fix migration issues}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with credentials from .env file and optionally fix migrations';

    /**
     * The migration dependencies
     */
    protected $migrationDependencies = [
        '2025_08_02_01_000001_create_job_posts_table.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_09_02_01_000002_create_job_applications_table.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
        ],
        '2025_10_02_01_000003_create_saved_jobs_table.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_11_02_15_000001_create_wallet_tables.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_11_02_15_000002_create_wallets_table.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_11_02_15_000003_create_transactions_table.php' => [
            '2025_11_02_15_000002_create_wallets_table.php',
        ],
        '2025_11_02_15_000004_add_task_id_to_transactions_table.php' => [
            '2025_11_02_15_000003_create_transactions_table.php',
            '2025_13_02_15_000003_create_tasks_table.php',
        ],
        '2025_12_02_15_000002_create_contracts_table.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_13_02_15_000003_create_tasks_table.php' => [
            '2025_12_02_15_000002_create_contracts_table.php',
        ],
        '2025_13_02_15_000004_add_client_id_to_tasks_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
        ],
        '2025_13_02_15_000005_add_contract_id_to_tasks_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
            '2025_12_02_15_000002_create_contracts_table.php',
        ],
        '2025_13_02_15_000006_create_task_attachments_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
        ],
        '2025_13_02_15_000007_create_file_submissions_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
        ],
        '2025_14_02_15_000004_create_work_logs_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
        ],
        '2025_14_02_20_195020_create_messages_table.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_15_02_20_000001_create_job_post_skill_table.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
            '2025_05_01_01_000001_create_categories_and_skills_tables.php',
        ],
        '2025_16_03_01_000001_create_applications_table.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_17_04_01_000001_add_admin_to_user_type_enum.php' => [
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_18_04_06_000001_update_job_posts_table.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
        ],
        '2025_19_01_01_000001_add_application_deadline_to_job_posts.php' => [
            '2025_08_02_01_000001_create_job_posts_table.php',
        ],
        '2025_20_06_01_000001_create_submissions_table.php' => [
            '2025_13_02_15_000003_create_tasks_table.php',
            '2025_01_10_12_000000_create_users_table.php',
        ],
        '2025_04_21_094608_add_currency_and_payment_fields_to_wallets_and_transactions.php' => [
            '2025_11_02_15_000002_create_wallets_table.php',
            '2025_11_02_15_000003_create_transactions_table.php',
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fix migrations if option is provided
        if ($this->option('fix-migrations')) {
            $this->fixMigrations();
        }

        $adminEmail = env('ADMIN_EMAIL', 'admin@ajira.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@123');

        // First, ensure the user_type enum includes 'admin'
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('client', 'job-seeker', 'admin') DEFAULT NULL");
            $this->info("Updated user_type enum to include 'admin'");
        } catch (\Exception $e) {
            $this->error("Could not update user_type enum: " . $e->getMessage());
            // Continue anyway as the enum might already include 'admin'
        }

        // Check if admin already exists
        if (DB::table('users')->where('email', $adminEmail)->exists()) {
            $this->info('Admin user already exists. Updating password...');
            DB::table('users')
                ->where('email', $adminEmail)
                ->update([
                    'password' => Hash::make($adminPassword),
                    'user_type' => 'admin'
                ]);
            $this->info('Admin credentials updated successfully.');
        } else {
            // Create new admin
            DB::table('users')->insert([
                'name' => 'Administrator',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info('Admin user created successfully.');
        }

        return Command::SUCCESS;
    }

    /**
     * Fix migration issues
     */
    protected function fixMigrations()
    {
        $this->info('Fixing migration issues...');

        // Step 1: Check if migrations table exists
        if (!Schema::hasTable('migrations')) {
            $this->warn('Migrations table does not exist. Creating it...');
            Artisan::call('migrate:install');
            $this->info('Migrations table created.');
        }

        // Step 2: Get all migrations from the database
        $dbMigrations = DB::table('migrations')->get()->keyBy('migration');
        
        // Step 3: Get all migration files from the filesystem
        $migrationPath = database_path('migrations');
        $migrationFiles = array_map('basename', glob($migrationPath . '/*.php'));
        
        // Step 4: Convert migration filenames to migration names
        $migrationNames = array_map(function ($filename) {
            return basename($filename, '.php');
        }, $migrationFiles);

        // Step 5: Find migrations in the database that don't have files
        foreach ($dbMigrations as $migration => $details) {
            if (!in_array($migration . '.php', $migrationFiles)) {
                $this->warn("Migration in database but not in filesystem: {$migration}");
            }
        }
        
        // Step 6: Find migrations in the filesystem that aren't in the database
        $missingMigrations = [];
        foreach ($migrationNames as $migration) {
            if (!isset($dbMigrations[$migration])) {
                $missingMigrations[] = $migration;
                $this->warn("Migration in filesystem but not in database: {$migration}");
            }
        }

        // Step 7: If there are missing migrations, try to run them in the correct order
        if (!empty($missingMigrations)) {
            $this->info('Running missing migrations in the correct order...');
            
            // Build dependency graph
            $graph = [];
            foreach ($this->migrationDependencies as $migration => $dependencies) {
                $migrationName = basename($migration, '.php');
                $graph[$migrationName] = [];
                
                foreach ($dependencies as $dep) {
                    $depName = basename($dep, '.php');
                    $graph[$migrationName][] = $depName;
                }
            }
            
            // Add migrations without explicit dependencies
            foreach ($migrationNames as $migration) {
                if (!isset($graph[$migration])) {
                    $graph[$migration] = [];
                }
            }
            
            // Topologically sort migrations
            $sorted = $this->topologicalSort($graph);
            
            // Filter to only missing migrations
            $missingMigrationsSet = array_flip($missingMigrations);
            $sortedMissing = array_filter($sorted, function ($migration) use ($missingMigrationsSet) {
                return isset($missingMigrationsSet[$migration]);
            });
            
            $this->info('Sorted migration order:');
            foreach ($sortedMissing as $migration) {
                $this->line(" - {$migration}");
            }
            
            // Run migrations in order
            foreach ($sortedMissing as $migration) {
                $this->info("Running migration: {$migration}");
                try {
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$migration}.php",
                        '--force' => true,
                    ]);
                    $output = Artisan::output();
                    $this->info($output);
                } catch (\Exception $e) {
                    $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                }
            }
        } else {
            $this->info('All migrations are already in the database.');
        }
        
        $this->info('Migration fix completed.');
    }

    /**
     * Topological sort for migrations
     */
    protected function topologicalSort($graph)
    {
        $visited = [];
        $temp = [];
        $order = [];
        
        // Visit function for DFS
        $visit = function ($node) use (&$visited, &$temp, &$order, &$graph, &$visit) {
            // If node is already in temporary marks, we have a cycle
            if (isset($temp[$node])) {
                throw new \Exception("Circular dependency detected: {$node}");
            }
            
            // If we haven't visited the node yet
            if (!isset($visited[$node])) {
                // Mark node as temporarily visited
                $temp[$node] = true;
                
                // Visit all dependencies
                if (isset($graph[$node])) {
                    foreach ($graph[$node] as $dependency) {
                        $visit($dependency);
                    }
                }
                
                // Mark node as permanently visited
                $visited[$node] = true;
                unset($temp[$node]);
                
                // Add to order
                $order[] = $node;
            }
        };
        
        // Visit all nodes
        foreach (array_keys($graph) as $node) {
            if (!isset($visited[$node])) {
                $visit($node);
            }
        }
        
        return array_reverse($order);
    }
}
