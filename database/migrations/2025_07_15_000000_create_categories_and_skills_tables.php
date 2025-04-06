<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesAndSkillsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });

        // Skills Table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        // Pivot table for job posts and skills
        Schema::create('job_post_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['job_post_id', 'skill_id']);
        });

        // Pivot table for users and skills
        Schema::create('user_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->integer('proficiency_level')->nullable()->comment('On a scale of 1-5');
            $table->integer('years_experience')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'skill_id']);
        });

        // Update job_posts table to reference category_id
        Schema::table('job_posts', function (Blueprint $table) {
            // First check if the column doesn't already exist
            if (!Schema::hasColumn('job_posts', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('category')->constrained()->onDelete('set null');
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

        // Drop pivot tables
        Schema::dropIfExists('user_skill');
        Schema::dropIfExists('job_post_skill');
        
        // Drop main tables
        Schema::dropIfExists('skills');
        Schema::dropIfExists('categories');
    }
} 