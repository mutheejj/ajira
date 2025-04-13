<?php

/**
 * Laravel Migration Re-Ordering Script
 * 
 * This script renames migration files with appropriate timestamps
 * based on their dependencies to ensure they run in the correct order.
 */

// Define the old and new filenames in the order they should be executed
$migrationMap = [
    // Step 1: Core system tables
    '2025_01_01_000000_create_users_table.php' => '2014_10_12_000000_create_users_table.php',
    '2025_10_12_100000_create_password_resets_table.php' => '2014_10_12_100000_create_password_resets_table.php',
    '2025_08_19_000000_create_failed_jobs_table.php' => '2019_08_19_000000_create_failed_jobs_table.php',
    '2025_01_01_000004_create_email_verifications_table.php' => '2019_12_14_000001_create_email_verifications_table.php',
    
    // Step 2: Core functionality tables
    '2025_07_15_000000_create_categories_and_skills_tables.php' => '2020_01_01_000001_create_categories_and_skills_tables.php',
    '2025_07_15_000001_create_user_roles_table.php' => '2020_01_01_000002_create_roles_table.php',
    '2025_07_15_000002_create_profiles_table.php' => '2020_01_01_000003_create_profiles_table.php',
    
    // Step 3: Feature tables depending on users
    '2025_01_01_000001_create_job_posts_table.php' => '2020_02_01_000001_create_job_posts_table.php',
    '2025_01_01_000002_create_job_applications_table.php' => '2020_02_01_000002_create_job_applications_table.php',
    '2025_01_01_000003_create_saved_jobs_table.php' => '2020_02_01_000003_create_saved_jobs_table.php',
    '2025_01_01_000005_create_wallet_tables.php' => '2020_02_15_000001_create_wallet_tables.php',
    '2025_01_01_000006_create_contracts_table.php' => '2020_02_15_000002_create_contracts_table.php',
    '2025_01_01_000007_create_tasks_table.php' => '2020_02_15_000003_create_tasks_table.php',
    '2025_01_01_000008_create_work_logs_table.php' => '2020_02_15_000004_create_work_logs_table.php',
    
    // Step 4: Later updates
    '2025_05_20_create_applications_table.php' => '2020_03_01_000001_create_applications_table.php',
    '2025_04_06_000001_add_admin_to_user_type_enum.php' => '2020_04_01_000001_add_admin_to_user_type_enum.php',
    '2025_04_06_182847_update_job_posts_table.php' => '2020_04_06_000001_update_job_posts_table.php',
];

// Path to the migrations directory
$migrationsDir = __DIR__ . '/migrations/';

// Check if the directory exists
if (!is_dir($migrationsDir)) {
    die("ERROR: Migrations directory not found at {$migrationsDir}\n");
}

// Rename the migration files
$renamed = 0;
$notFound = [];

echo "Starting migration file renaming process...\n";

foreach ($migrationMap as $oldName => $newName) {
    $oldPath = $migrationsDir . $oldName;
    $newPath = $migrationsDir . $newName;
    
    if (file_exists($oldPath)) {
        if (rename($oldPath, $newPath)) {
            echo "Renamed: {$oldName} → {$newName}\n";
            $renamed++;
        } else {
            echo "ERROR: Failed to rename {$oldName}\n";
        }
    } else {
        $notFound[] = $oldName;
    }
}

echo "\nRenaming complete!\n";
echo "Total files renamed: {$renamed}\n";

if (count($notFound) > 0) {
    echo "\nThe following files were not found:\n";
    foreach ($notFound as $file) {
        echo "- {$file}\n";
    }
}

echo "\nNote: If you're working with a version control system, don't forget to commit these changes.\n";
echo "Also, if you need to recreate the database, you may need to run: php artisan migrate:fresh\n";
?> 