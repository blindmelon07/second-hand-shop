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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->unsignedBigInteger('category_id')->constrained()->onDelete('cascade');
            $table->enum('condition', ['like_new', 'excellent', 'good', 'fair', 'poor'])->default('good');
            $table->integer('usage_months')->nullable();
            $table->text('usage_details')->nullable();
            $table->boolean('has_warranty')->default(false);
            $table->text('warranty_details')->nullable();
            $table->boolean('is_negotiable')->default(true);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('meetup_location')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};