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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('type'); // veg, non-veg
            $table->string('cuisine');
            $table->integer('price');
            $table->integer('original_price')->nullable();
            $table->double('rating')->default(5.0);
            $table->integer('review_count')->default(0);
            $table->string('prep_time')->nullable();
            $table->integer('servings')->default(1);
            $table->integer('calories')->nullable();
            $table->string('spice_level')->nullable(); // None, Mild, Medium, Hot
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable(); // JSON array
            $table->text('tags')->nullable(); // JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
