<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change the enum values for user_type to include 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('client', 'job-seeker', 'admin') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('client', 'job-seeker') DEFAULT NULL");
    }
}; 