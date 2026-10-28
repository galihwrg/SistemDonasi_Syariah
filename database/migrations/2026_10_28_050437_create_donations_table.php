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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
            $table->string('donor_name');
            $table->string('donor_contact')->nullable();
            $table->text('prayer_message')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('midtrans_order_id')->unique()->nullable();
            $table->string('midtrans_snap_token')->nullable();
            $table->enum('payment_method', ['qris', 'bsi_va', 'bank_transfer'])->nullable();
            $table->enum('payment_status', ['pending', 'settlement', 'expired', 'cancel'])->default('pending');
            $table->boolean('is_royalty_settled')->default(false);
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
