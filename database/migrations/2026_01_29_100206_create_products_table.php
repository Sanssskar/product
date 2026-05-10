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
            $table->string('title');
            $table->longText('description');
            $table->double('price');
            $table->double('discount');
            $table->string('image');
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('featured_order')->nullable();
            $table->string('featured_image')->nullable(); 
            $table->foreignId('category_id')->constrained()->cascadeonDelete();
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
