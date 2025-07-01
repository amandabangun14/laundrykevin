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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'received', 'washing', 'ironing', 'completed', 'ready_for_pickup', 'picked_up'])->default('pending');
            $table->decimal('total_weight', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->date('pickup_date')->nullable();
            $table->date('estimated_completion_date');
            $table->date('actual_completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
