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
            $table->foreignId("tenant_id");
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string("name");
            $table->string("code")->unique();
            $table->decimal('quantity')->default(1);
            $table->decimal('price')->default(0);
            $table->decimal("safety_stock")->default(0);
            $table->text("description")->nullable();
            $table->foreignId("unit_id")->references('id')->on('units');
            $table->json("data")->nullable();
            $table->date('expires_at')->nullable();
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
