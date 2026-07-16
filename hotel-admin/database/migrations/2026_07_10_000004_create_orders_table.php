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
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('delivery_address'); // Room number or Restaurant Table or Home Address
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('delivery_charge')->default(0);
            $table->integer('total');
            $table->string('status')->default('Pending'); // Pending, Preparing, Out for Delivery, Delivered, Cancelled
            $table->string('payment_status')->default('Pending'); // Pending, Paid, Failed
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
