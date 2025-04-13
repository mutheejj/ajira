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
        // Pivot table for job posts and skills
        Schema::create('job_post_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['job_post_id', 'skill_id']);
        });

        // Update job_posts table to reference category_id
        Schema::table('job_posts', function (Blueprint $table) {
            // First check if the column doesn't already exist
            if (!Schema::hasColumn('job_posts', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('category')->constrained('categories')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key from job_posts table
        Schema::table('job_posts', function (Blueprint $table) {
            if (Schema::hasColumn('job_posts', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });

        // Drop pivot table
        Schema::dropIfExists('job_post_skill');
    }
}; 