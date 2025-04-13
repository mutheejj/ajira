<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the job_posts table exists
        if (!Schema::hasTable('job_posts')) {
            return;
        }

        // Handle adding new columns first
        Schema::table('job_posts', function (Blueprint $table) {
            // Only add columns if they don't already exist
            if (!Schema::hasColumn('job_posts', 'rate_type')) {
                $table->enum('rate_type', ['fixed', 'hourly'])->default('fixed');
            }
            
            if (!Schema::hasColumn('job_posts', 'job_type')) {
                $table->enum('job_type', ['one-time', 'ongoing'])->default('one-time');
            }
            
            if (!Schema::hasColumn('job_posts', 'location_type')) {
                $table->enum('location_type', ['remote', 'on-site', 'hybrid'])->default('remote');
            }
            
            if (!Schema::hasColumn('job_posts', 'attachment')) {
                $table->string('attachment')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the job_posts table exists
        if (!Schema::hasTable('job_posts')) {
            return;
        }
        
        // Remove added columns
        Schema::table('job_posts', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('job_posts', 'rate_type')) {
                $table->dropColumn('rate_type');
            }
            
            if (Schema::hasColumn('job_posts', 'job_type')) {
                $table->dropColumn('job_type');
            }
            
            if (Schema::hasColumn('job_posts', 'location_type')) {
                $table->dropColumn('location_type');
            }
            
            if (Schema::hasColumn('job_posts', 'attachment')) {
                $table->dropColumn('attachment');
            }
        });
    }
};
