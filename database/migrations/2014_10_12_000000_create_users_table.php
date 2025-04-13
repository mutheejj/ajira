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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['client', 'job-seeker'])->nullable();
            
            // Client fields
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->string('company_size', 100)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            
            // Job Seeker fields
            $table->string('profession')->nullable();
            $table->string('experience')->nullable();
            $table->json('skills')->nullable();
            $table->text('bio')->nullable();
            
            // Profile media
            $table->string('profile_picture')->nullable();
            $table->string('resume')->nullable();
            $table->string('portfolio')->nullable();
            
            // Social links
            $table->string('github_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('personal_website')->nullable();
            
            // Preferences
            $table->string('currency', 3)->default('KSH');
            $table->text('portfolio_description')->nullable();
            
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
