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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_seeker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->string('resume')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'interviewed', 'rejected', 'accepted'])->default('pending');
            $table->integer('current_step')->default(0);
            $table->json('steps')->default(json_encode([]));
            $table->timestamp('applied_date')->useCurrent();
            $table->timestamp('last_updated')->nullable()->useCurrentOnUpdate();
            $table->timestamps();

            // Prevent duplicate applications
            $table->unique(['job_seeker_id', 'job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};