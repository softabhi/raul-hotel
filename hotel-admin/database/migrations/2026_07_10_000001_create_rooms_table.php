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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // Standard, Deluxe, Suite, Presidential
            $table->integer('price');
            $table->integer('original_price')->nullable();
            $table->integer('capacity');
            $table->string('size');
            $table->string('bed');
            $table->string('floor');
            $table->string('view');
            $table->double('rating')->default(5.0);
            $table->integer('review_count')->default(0);
            $table->boolean('available')->default(true);
            $table->string('image')->nullable();
            $table->text('amenities')->nullable(); // JSON array
            $table->text('description')->nullable();
            $table->text('highlights')->nullable(); // JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
