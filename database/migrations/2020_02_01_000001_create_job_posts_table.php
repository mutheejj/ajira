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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->text('requirements');
            $table->json('skills');
            $table->enum('experience_level', ['entry', 'intermediate', 'expert']);
            $table->enum('project_type', ['full_time', 'part_time', 'contract', 'freelance']);
            $table->decimal('budget', 10, 2);
            $table->enum('currency', ['KSH', 'USD'])->default('KSH');
            $table->integer('duration')->comment('Duration in days');
            $table->string('location')->nullable();
            $table->boolean('remote_work')->default(false);
            $table->enum('status', ['active', 'closed', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
}; 