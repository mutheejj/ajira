<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->decimal('reserved_balance', 10, 2)->default(0.00);
            $table->string('currency')->default('USD');
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->unique('user_id');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // deposit, withdrawal, payment, fee, refund, purchase
            $table->string('status')->default('pending'); // pending, completed, failed, cancelled
            $table->string('description')->nullable();
            $table->string('reference')->nullable(); // Reference or transaction ID
            $table->json('meta')->nullable(); // Additional metadata
            $table->timestamps();
            
            $table->index('wallet_id');
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('wallets');
    }
} 