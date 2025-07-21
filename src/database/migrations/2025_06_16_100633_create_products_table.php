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
            $table->string('name');  // Name of the product (jersey)
            $table->decimal('price', 8, 2);  // Price with two decimal places
            $table->string('size');  // Size of the jersey (S, M, L, XL)
            $table->string('color');  // Color of the jersey
            $table->integer('stock');  // Stock of the product
            $table->string('image')->nullable();  // Image of the product (can be null initially)
            $table->timestamps();  // Created at & Updated at
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
