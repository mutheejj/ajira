<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class FixMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrations:fix 
                            {--reset : Reset the database and run all migrations in correct order} 
                            {--check : Only check for issues without fixing} 
                            {--fix-task-tables : Fix task related tables first}
                            {--check-structure : Check database structure and tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix migration ordering issues and dependencies';

    /**
     * Known problematic migrations that should be skipped in certain scenarios
     */
    protected $problematicMigrations = [
        '2025_11_02_15_000001_create_wallet_tables.php',
        '2025_04_21_094608_add_currency_and_payment_fields_to_wallets_and_transactions.php',
    ];

    /**
     * The base core migrations that should run first
     */
    protected $coreMigrations = [
        '2025_01_10_12_000000_create_users_table.php',
        '2025_02_10_12_100000_create_password_resets_table.php',
        '2025_03_08_19_000000_create_failed_jobs_table.php',
        '2025_04_12_14_000001_create_email_verifications_table.php',
        '2025_05_12_14_000001_create_personal_access_tokens_table.php',
        '2025_05_01_01_000001_create_categories_and_skills_tables.php',
        '2025_06_01_01_000002_create_roles_table.php',
        '2025_07_01_01_000003_create_profiles_table.php',
    ];

    /**
     * The secondary migrations (after core but before others)
     */
    protected $secondaryMigrations = [
        '2025_08_02_01_000001_create_job_posts_table.php',
        '2025_12_02_15_000002_create_contracts_table.php',
        '2025_13_02_15_000003_create_tasks_table.php',
        '2025_11_02_15_000002_create_wallets_table.php',
        '2025_11_02_15_000003_create_transactions_table.php',
    ];

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
        'create_wallets_table.php' => [],
        'create_wallet_transactions_table.php' => ['create_wallets_table.php'],
        'create_addresses_to_wallets_table.php' => ['create_wallets_table.php', 'create_addresses_table.php'],
        'wallet_to_has_wallet.php' => ['create_wallets_table.php'],
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking migration issues...');

        // Get all migration files
        $migrationPath = database_path('migrations');
        $migrationFiles = array_map('basename', glob($migrationPath . '/*.php'));
        
        // Convert migration filenames to migration names
        $migrationNames = array_map(function ($filename) {
            return basename($filename, '.php');
        }, $migrationFiles);

        // If check-structure option is used, show database structure
        if ($this->option('check-structure')) {
            return $this->checkDatabaseStructure();
        }

        // If fix-task-tables option is used, ensure the tasks related tables exist
        if ($this->option('fix-task-tables')) {
            return $this->fixTaskTables($migrationFiles);
        }

        // If reset option is used, completely drop and recreate everything
        if ($this->option('reset')) {
            return $this->resetAndRunMigrations();
        }

        // If only checking, analyze but don't fix
        if ($this->option('check')) {
            return $this->checkMigrations($migrationFiles);
        }

        // Otherwise, try to fix migrations without a full reset
        return $this->fixExistingMigrations($migrationFiles);
    }

    /**
     * Check the database structure and report on tables
     */
    protected function checkDatabaseStructure()
    {
        $this->info('Checking database structure...');
        
        // First check if migrations table exists
        if (!Schema::hasTable('migrations')) {
            $this->error('Migrations table does not exist. The database has not been initialized.');
            return Command::FAILURE;
        }
        
        // Get a list of tables
        $tables = DB::select('SHOW TABLES');
        $tablePrefix = DB::getTablePrefix();
        $tableColumnName = 'Tables_in_' . config('database.connections.mysql.database');
        
        $this->info('Database tables:');
        $tablesList = [];
        foreach ($tables as $table) {
            $tableName = $table->$tableColumnName;
            $tablesList[] = $tableName;
            
            // Get column information for each table
            $columns = DB::select("DESCRIBE {$tableName}");
            $columnsList = [];
            foreach ($columns as $column) {
                $columnsList[] = [
                    'name' => $column->Field,
                    'type' => $column->Type,
                    'nullable' => $column->Null === 'YES',
                    'key' => $column->Key,
                    'default' => $column->Default,
                ];
            }
            
            $this->line(" - {$tableName} (" . count($columnsList) . " columns)");
            
            // Show detailed column information if requested
            if ($this->confirm("   Show column details for {$tableName}?", false)) {
                $this->table(
                    ['Column', 'Type', 'Nullable', 'Key', 'Default'],
                    array_map(function($col) {
                        return [
                            $col['name'],
                            $col['type'],
                            $col['nullable'] ? 'YES' : 'NO',
                            $col['key'],
                            $col['default'] ?? 'NULL',
                        ];
                    }, $columnsList)
                );
            }
        }
        
        // Check for problematic migrations
        $this->info('Checking for problematic migrations...');
        $migrationsRun = DB::table('migrations')->get()->pluck('migration')->toArray();
        $problemsFound = false;
        
        // Check for duplicate wallet tables
        if (in_array('2025_11_02_15_000001_create_wallet_tables', $migrationsRun) && 
            in_array('2025_11_02_15_000002_create_wallets_table', $migrationsRun)) {
            $this->warn('Both wallet table migrations were run which may cause conflicts');
            $problemsFound = true;
        }
        
        // Check for duplicate currency column
        if (in_array('2025_04_21_094608_add_currency_and_payment_fields_to_wallets_and_transactions', $migrationsRun) &&
            Schema::hasTable('wallets') && Schema::hasColumn('wallets', 'currency')) {
            $this->warn('The wallets table already has a currency column which may conflict with the add_currency migration');
            $problemsFound = true;
        }
        
        if (!$problemsFound) {
            $this->info('No known problematic migrations found.');
        }
        
        $this->info('Database structure check complete.');
        return Command::SUCCESS;
    }

    /**
     * Fix task-related tables that might have foreign key constraint issues
     */
    protected function fixTaskTables($migrationFiles)
    {
        $this->info('Fixing task-related tables...');

        // Check if migrations table exists
        if (!Schema::hasTable('migrations')) {
            $this->error('Migrations table does not exist. The database has not been initialized.');
            $this->info('Run php artisan migrations:fix --reset to initialize the database.');
            return Command::FAILURE;
        }

        // Get the key tasks-related tables
        $keyTables = [
            'contracts' => [
                'migration' => '2025_12_02_15_000002_create_contracts_table.php',
                'exists' => Schema::hasTable('contracts'),
            ],
            'tasks' => [
                'migration' => '2025_13_02_15_000003_create_tasks_table.php',
                'exists' => Schema::hasTable('tasks'),
            ],
            'submissions' => [
                'migration' => '2025_20_06_01_000001_create_submissions_table.php',
                'exists' => Schema::hasTable('submissions'),
            ],
        ];

        // Check for existence and try to create them in order
        foreach ($keyTables as $table => $info) {
            if (!$info['exists']) {
                $this->warn("The {$table} table does not exist. Attempting to create it...");
                
                try {
                    $this->info("Running migration: {$info['migration']}");
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$info['migration']}",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                } catch (\Exception $e) {
                    $this->error("Failed to create {$table} table: " . $e->getMessage());
                    
                    // If we failed on 'submissions', try to fix its dependency issues
                    if ($table === 'submissions') {
                        $this->warn("Attempting to fix submissions table by ensuring tasks table exists...");
                        
                        // Check if task table migration has been run
                        if (!Schema::hasTable('tasks')) {
                            $this->error("The tasks table does not exist. It's a prerequisite for submissions.");
                            
                            try {
                                $this->info("Running tasks migration first: 2025_13_02_15_000003_create_tasks_table.php");
                                Artisan::call('migrate', [
                                    '--path' => "database/migrations/2025_13_02_15_000003_create_tasks_table.php",
                                    '--force' => true,
                                ]);
                                $this->info(Artisan::output());
                                
                                // Now try again with submissions
                                $this->info("Retrying submissions migration");
                                Artisan::call('migrate', [
                                    '--path' => "database/migrations/{$info['migration']}",
                                    '--force' => true,
                                ]);
                                $this->info(Artisan::output());
                            } catch (\Exception $innerE) {
                                $this->error("Failed in second attempt: " . $innerE->getMessage());
                                $this->warn("You may need to use the --reset option for a complete fix.");
                            }
                        }
                    }
                }
            } else {
                $this->info("The {$table} table already exists.");
            }
        }

        $this->info('Task table fixing completed.');
        return Command::SUCCESS;
    }

    /**
     * Reset the database and run all migrations in the correct order
     */
    protected function resetAndRunMigrations()
    {
        $this->info('Resetting the database and running all migrations in the correct order...');

        if (!$this->confirm('This will DROP ALL TABLES in your database. Are you sure you want to continue?', false)) {
            $this->info('Operation canceled.');
            return Command::FAILURE;
        }

        // Drop all tables
        $this->info('Dropping all tables...');
        Artisan::call('db:wipe', ['--force' => true]);
        $this->info(Artisan::output());

        // Create migrations table
        $this->info('Creating migrations table...');
        Artisan::call('migrate:install');

        // Get all migration files
        $migrationPath = database_path('migrations');
        $migrationFiles = array_map('basename', glob($migrationPath . '/*.php'));

        // Order migrations by dependencies
        $this->info('Calculating migration order...');
        $orderedMigrations = $this->orderMigrations($migrationFiles);
        
        // Convert migration filenames to migration names for later checks
        $migrationNames = array_map(function ($filename) {
            return basename($filename, '.php');
        }, $migrationFiles);

        // Create the batch value we'll use
        $batchValue = 1;

        // Run core migrations first
        $this->info('Running core migrations...');
        $coreMigrationNames = array_map(function($file) {
            return basename($file, '.php');
        }, $this->coreMigrations);

        foreach ($coreMigrationNames as $migration) {
            if (in_array($migration.'.php', $migrationFiles)) {
                $this->info("Running migration: {$migration}");
                try {
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$migration}.php",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                    
                    // Verify the migration was successful by checking if table exists
                    $tableName = $this->getTableNameFromMigration($migration);
                    if ($tableName && !$this->tableExists($tableName)) {
                        $this->error("Migration ran, but table {$tableName} was not created!");
                    }
                } catch (\Exception $e) {
                    $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                    return Command::FAILURE;
                }
            }
        }

        // Run critical secondary migrations 
        $this->info('Running critical secondary migrations...');
        $secondaryMigrationNames = array_map(function($file) {
            return basename($file, '.php');
        }, $this->secondaryMigrations);

        // Keep track of which tables have been created to prevent duplicates
        $createdTables = [];

        foreach ($secondaryMigrationNames as $migration) {
            if (in_array($migration.'.php', $migrationFiles)) {
                $tableName = $this->getTableNameFromMigration($migration);
                
                // Skip if we've already created this table
                if ($tableName && $this->tableExists($tableName)) {
                    $this->info("Table {$tableName} already exists, skipping migration: {$migration}");
                    continue;
                }
                
                $this->info("Running secondary migration: {$migration}");
                try {
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$migration}.php",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                    
                    // Record that we've created this table
                    if ($tableName) {
                        $createdTables[] = $tableName;
                    }
                    
                    // Verify the migration was successful
                    if ($tableName && !$this->tableExists($tableName)) {
                        $this->error("Migration ran, but table {$tableName} was not created!");
                    }
                } catch (\Exception $e) {
                    $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                    // We'll continue despite errors in secondary migrations
                }
            }
        }

        // Then run the rest of the migrations in order
        $this->info('Running remaining migrations in dependency order...');
        foreach ($orderedMigrations as $migration) {
            // Skip if already run (was in core or secondary migrations)
            if (in_array($migration, $coreMigrationNames) || in_array($migration, $secondaryMigrationNames)) {
                continue;
            }
            
            // Check if this is a create_table migration and if the table already exists
            $tableName = $this->getTableNameFromMigration($migration);
            $isCreateTable = strpos($migration, 'create_') !== false && strpos($migration, '_table') !== false;
            
            if ($isCreateTable && $tableName && $this->tableExists($tableName)) {
                $this->info("Table {$tableName} already exists, skipping migration: {$migration}");
                continue;
            }
            
            // Check if this is an add column migration and the table doesn't exist
            $isAddColumn = strpos($migration, 'add_') !== false && strpos($migration, '_to_') !== false;
            if ($isAddColumn && $tableName && !$this->tableExists($tableName)) {
                $this->warn("Table {$tableName} doesn't exist, skipping column addition migration: {$migration}");
                continue;
            }
            
            // Extract column name for add_column migrations
            $columnName = null;
            if ($isAddColumn) {
                preg_match('/add_(\w+)_to_/', $migration, $matches);
                if (isset($matches[1])) {
                    $columnName = $matches[1];
                    // Check if column already exists
                    if ($this->tableExists($tableName) && $this->columnExists($tableName, $columnName)) {
                        $this->info("Column {$columnName} already exists in table {$tableName}, skipping migration: {$migration}");
                        continue;
                    }
                }
            }
            
            $this->info("Running migration: {$migration}");
            try {
                Artisan::call('migrate', [
                    '--path' => "database/migrations/{$migration}.php",
                    '--force' => true,
                ]);
                $this->info(Artisan::output());
            } catch (\Exception $e) {
                // Handle duplicate table errors gracefully
                if (strpos($e->getMessage(), "already exists") !== false) {
                    $this->warn("Table already exists, continuing: " . $e->getMessage());
                } 
                // Handle duplicate column errors gracefully
                else if (strpos($e->getMessage(), "Duplicate column name") !== false) {
                    $this->warn("Column already exists, continuing: " . $e->getMessage());
                }
                else {
                    $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                }
                $this->warn("Continuing with remaining migrations despite this error.");
                // Continue with other migrations rather than stopping
            }
        }

        // Run one final check to find any migrations that weren't run
        $this->info('Checking for any missed migrations...');
        $dbMigrations = DB::table('migrations')->get()->keyBy('migration');
        $missed = [];
        
        foreach ($migrationNames as $migration) {
            if (!isset($dbMigrations[$migration])) {
                $missed[] = $migration;
                $this->warn("Migration not run: {$migration}");
            }
        }
        
        if (!empty($missed)) {
            $this->info('Attempting to run missed migrations...');
            foreach ($missed as $migration) {
                try {
                    // Skip known problematic migrations with duplication issues
                    if (strpos($migration, 'create_wallet_tables') !== false || 
                        strpos($migration, 'add_currency_and_payment_fields_to_wallets_and_transactions') !== false) {
                        $this->warn("Skipping known problematic migration: {$migration}");
                        continue;
                    }
                    
                    // Extract table and column information to avoid duplicates
                    $tableName = $this->getTableNameFromMigration($migration);
                    $isCreateTable = strpos($migration, 'create_') !== false && strpos($migration, '_table') !== false;
                    $isAddColumn = strpos($migration, 'add_') !== false && strpos($migration, '_to_') !== false;
                    
                    // Skip if table already exists for create_table migrations
                    if ($isCreateTable && $tableName && $this->tableExists($tableName)) {
                        $this->info("Table {$tableName} already exists, skipping missed migration: {$migration}");
                        continue;
                    }
                    
                    // Skip if column already exists for add_column migrations
                    if ($isAddColumn) {
                        preg_match('/add_(\w+)_to_/', $migration, $matches);
                        if (isset($matches[1]) && $tableName) {
                            $columnName = $matches[1];
                            if ($this->tableExists($tableName) && $this->columnExists($tableName, $columnName)) {
                                $this->info("Column {$columnName} already exists in table {$tableName}, skipping missed migration: {$migration}");
                                continue;
                            }
                        }
                    }
                    
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$migration}.php",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                } catch (\Exception $e) {
                    $this->error("Failed to run missed migration {$migration}: " . $e->getMessage());
                }
            }
        }

        $this->info('All migrations have been processed!');
        $this->info('Running admin setup...');
        
        Artisan::call('create:admin');
        $this->info(Artisan::output());
        
        return Command::SUCCESS;
    }

    /**
     * Extract table name from migration name
     */
    protected function getTableNameFromMigration($migration)
    {
        $parts = explode('_', $migration);
        $actionParts = array_slice($parts, 5); // Skip datetime prefix
        
        if (count($actionParts) >= 3) {
            if ($actionParts[0] === 'create' && $actionParts[count($actionParts) - 1] === 'table') {
                // Handle "create_X_table" pattern
                $tableNameParts = array_slice($actionParts, 1, -1);
                return implode('_', $tableNameParts);
            } elseif ($actionParts[0] === 'add' && isset($actionParts[count($actionParts) - 2]) && $actionParts[count($actionParts) - 1] === 'table') {
                // Handle "add_X_to_Y_table" pattern
                return $actionParts[count($actionParts) - 2];
            }
        }
        
        return null;
    }

    /**
     * Check for migration issues without fixing
     */
    protected function checkMigrations($migrationFiles)
    {
        // Check if migrations table exists
        if (!Schema::hasTable('migrations')) {
            $this->error('Migrations table does not exist. The database has not been initialized.');
            $this->info('Run php artisan migrations:fix --reset to initialize the database.');
            return Command::FAILURE;
        }

        // Get migration records from database
        $dbMigrations = DB::table('migrations')->get()->keyBy('migration');
        
        // Convert migration filenames to migration names
        $migrationNames = array_map(function ($filename) {
            return basename($filename, '.php');
        }, $migrationFiles);

        $this->info('Checking migration status...');
        
        // Find migrations in the database that don't have files
        $missingFiles = [];
        foreach ($dbMigrations as $migration => $details) {
            if (!in_array($migration . '.php', $migrationFiles)) {
                $missingFiles[] = $migration;
                $this->warn("Migration in database but not in filesystem: {$migration}");
            }
        }
        
        // Find migrations in the filesystem that aren't in the database
        $missingMigrations = [];
        foreach ($migrationFiles as $migration) {
            $migrationName = basename($migration, '.php');
            if (!isset($dbMigrations[$migrationName])) {
                $missingMigrations[] = $migrationName;
                $this->warn("Migration in filesystem but not in database: {$migrationName}");
            }
        }

        if (empty($missingFiles) && empty($missingMigrations)) {
            $this->info('All migrations are in sync. No issues found.');
            return Command::SUCCESS;
        }

        if (!empty($missingFiles)) {
            $this->warn('The migrations above exist in the database but the files are missing.');
        }
        
        if (!empty($missingMigrations)) {
            $this->warn('The migrations above exist as files but have not been run in the database.');
            
            // Check dependencies of missing migrations
            $this->info('Checking dependencies of missing migrations...');
            $dependencyIssues = false;
            foreach ($missingMigrations as $migration) {
                $migrationFile = $migration . '.php';
                if (isset($this->migrationDependencies[$migrationFile])) {
                    foreach ($this->migrationDependencies[$migrationFile] as $dependency) {
                        $depName = basename($dependency, '.php');
                        if (!isset($dbMigrations[$depName])) {
                            $this->error("Migration {$migration} depends on {$depName} which is also not migrated.");
                            $dependencyIssues = true;
                        }
                    }
                }
            }
            
            if ($dependencyIssues) {
                $this->warn('There are dependency issues with the unmigrated files.');
                $this->warn('Please use php artisan migrations:fix to fix these issues.');
            }
        }
        
        return Command::FAILURE;
    }

    /**
     * Fix migrations without resetting the database
     */
    protected function fixExistingMigrations($migrationFiles)
    {
        // Check if migrations table exists
        if (!Schema::hasTable('migrations')) {
            $this->error('Migrations table does not exist. The database has not been initialized.');
            $this->info('Run php artisan migrations:fix --reset to initialize the database.');
            return Command::FAILURE;
        }

        // Get migration records from database
        $dbMigrations = DB::table('migrations')->get()->keyBy('migration');
        
        // Convert migration filenames to migration names
        $migrationNames = array_map(function ($filename) {
            return basename($filename, '.php');
        }, $migrationFiles);

        // Find migrations in the filesystem that aren't in the database
        $missingMigrations = [];
        foreach ($migrationFiles as $migration) {
            $migrationName = basename($migration, '.php');
            if (!isset($dbMigrations[$migrationName])) {
                $missingMigrations[] = $migrationName;
                $this->warn("Migration in filesystem but not in database: {$migrationName}");
            }
        }

        if (empty($missingMigrations)) {
            $this->info('All migrations are already in the database.');
            return Command::SUCCESS;
        }

        // Run missing migrations in the correct order
        $this->info('Running missing migrations in the correct order...');
        
        // Handle some key migrations first
        $keyMigrations = [
            '2025_12_02_15_000002_create_contracts_table.php',
            '2025_13_02_15_000003_create_tasks_table.php',
        ];
        
        foreach ($keyMigrations as $keyMigration) {
            $keyMigrationName = basename($keyMigration, '.php');
            
            if (in_array($keyMigrationName, $missingMigrations) && !Schema::hasTable($this->getTableNameFromMigration($keyMigrationName))) {
                $this->info("Running key migration first: {$keyMigrationName}");
                try {
                    Artisan::call('migrate', [
                        '--path' => "database/migrations/{$keyMigrationName}.php",
                        '--force' => true,
                    ]);
                    $this->info(Artisan::output());
                    
                    // Remove from missing list as it's now been handled
                    $key = array_search($keyMigrationName, $missingMigrations);
                    if ($key !== false) {
                        unset($missingMigrations[$key]);
                    }
                } catch (\Exception $e) {
                    $this->error("Failed to run key migration {$keyMigrationName}: " . $e->getMessage());
                }
            }
        }
        
        // Order all migrations by dependencies
        $orderedMigrations = $this->orderMigrations($migrationFiles);
        
        // Filter to only include missing migrations
        $missingMigrationsSet = array_flip($missingMigrations);
        $orderedMissingMigrations = array_filter($orderedMigrations, function ($migration) use ($missingMigrationsSet) {
            return isset($missingMigrationsSet[$migration]);
        });
        
        $this->info('Migrations will run in this order:');
        foreach ($orderedMissingMigrations as $migration) {
            $this->line(" - {$migration}");
        }
        
        if (!$this->confirm('Do you want to run these migrations?', true)) {
            $this->info('Operation canceled.');
            return Command::FAILURE;
        }
        
        // Find the current batch number
        $currentBatch = 1;
        if (count($dbMigrations) > 0) {
            $currentBatch = DB::table('migrations')->max('batch') + 1;
        }
        
        // Run migrations
        $success = true;
        foreach ($orderedMissingMigrations as $migration) {
            $this->info("Running migration: {$migration}");
            try {
                Artisan::call('migrate', [
                    '--path' => "database/migrations/{$migration}.php",
                    '--force' => true,
                ]);
                $this->info(Artisan::output());
            } catch (\Exception $e) {
                $this->error("Failed to run migration {$migration}: " . $e->getMessage());
                $success = false;
                
                // Special handling for common foreign key issues
                if (strpos($e->getMessage(), "Foreign key constraint is incorrectly formed") !== false) {
                    $this->warn("Foreign key constraint issue detected. This usually means a referenced table doesn't exist.");
                    $this->warn("Consider running php artisan migrations:fix --fix-task-tables to fix task-related tables first.");
                }
                
                // Don't stop, try to run the remaining migrations
            }
        }
        
        if ($success) {
            $this->info('All missing migrations have been run successfully!');
            return Command::SUCCESS;
        } else {
            $this->warn('Some migrations failed. You may need to use the --reset option for a complete fix.');
            return Command::FAILURE;
        }
    }

    /**
     * Order migrations by their dependencies using topological sort
     */
    protected function orderMigrations($migrationFiles)
    {
        // Create a graph of dependencies
        $graph = [];
        
        // Initialize graph with all migrations
        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.php');
            $graph[$migrationName] = [];
        }
        
        // Add dependencies to the graph
        foreach ($this->migrationDependencies as $migration => $dependencies) {
            $migrationName = basename($migration, '.php');
            if (!isset($graph[$migrationName])) {
                $graph[$migrationName] = [];
            }
            
            foreach ($dependencies as $dep) {
                $depName = basename($dep, '.php');
                if (!in_array($depName, $graph[$migrationName])) {
                    $graph[$migrationName][] = $depName;
                }
            }
        }
        
        // Make sure we have transitive dependencies covered
        $this->addTransitiveDependencies($graph);
        
        // Perform topological sort
        return $this->topologicalSort($graph);
    }
    
    /**
     * Add transitive dependencies to ensure correct ordering
     */
    protected function addTransitiveDependencies(&$graph)
    {
        // For each node
        foreach ($graph as $node => $deps) {
            // For each of its dependencies
            foreach ($deps as $dep) {
                // If the dependency has its own dependencies
                if (isset($graph[$dep])) {
                    // Add those dependencies to the current node as well
                    foreach ($graph[$dep] as $transitiveDep) {
                        if ($transitiveDep !== $node && !in_array($transitiveDep, $graph[$node])) {
                            $graph[$node][] = $transitiveDep;
                        }
                    }
                }
            }
        }
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
                $this->warn("Circular dependency detected: {$node}");
                // Don't throw exception, just warn and continue
                return;
            }
            
            // If we haven't visited the node yet
            if (!isset($visited[$node])) {
                // Mark node as temporarily visited
                $temp[$node] = true;
                
                // Visit all dependencies
                if (isset($graph[$node])) {
                    foreach ($graph[$node] as $dependency) {
                        // Skip if dependency doesn't exist in graph
                        if (!isset($graph[$dependency])) {
                            continue;
                        }
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

    /**
     * Check if a table already exists and handle it
     *
     * @param string $tableName
     * @return bool True if already exists
     */
    protected function tableExists($tableName)
    {
        if (Schema::hasTable($tableName)) {
            $this->warn("Table $tableName already exists. Skipping creation.");
            return true;
        }
        return false;
    }

    /**
     * Check if a column already exists in a table and handle it
     *
     * @param string $tableName
     * @param string $columnName
     * @return bool True if already exists
     */
    protected function columnExists($tableName, $columnName)
    {
        if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, $columnName)) {
            $this->warn("Column $columnName already exists in table $tableName. Skipping creation.");
            return true;
        }
        return false;
    }
}
