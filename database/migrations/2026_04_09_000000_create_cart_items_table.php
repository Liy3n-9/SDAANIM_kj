<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cart_items')) {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id('cart_id');
                $table->string('Usu_documento');
                $table->unsignedBigInteger('prod_id');
                $table->integer('cart_cantidad');
                $table->timestamps();

                $table->foreign('Usu_documento')->references('Usu_documento')->on('users')->onDelete('cascade');
                $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('cascade');
                $table->unique(['Usu_documento', 'prod_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
