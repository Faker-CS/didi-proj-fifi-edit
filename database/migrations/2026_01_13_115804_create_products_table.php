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
                $table->id(); // id auto-incrémenté
                $table->string('name'); // nom du produit
                $table->text('description')->nullable(); // description
                $table->decimal('price'); // prix
                $table->integer('stock')->default(0); // quantité en stock
                $table->foreignId('category_id')->constrained()->onDelete('cascade'); // clé étrangère vers Category
                $table->string('image')->nullable();
                $table->timestamps(); // created_at et updated_at
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
