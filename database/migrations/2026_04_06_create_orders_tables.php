<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id('ord_id');
                $table->string('Usu_documento');
                $table->enum('ord_estado', ['pendiente', 'confirmado', 'recogido', 'cancelado'])->default('pendiente');
                $table->dateTime('ord_fechaCreacion');
                $table->dateTime('ord_fechaExpiracion')->nullable();
                $table->dateTime('ord_fechaRecogida')->nullable();
                $table->decimal('ord_total', 12, 2)->default(0);
                $table->timestamps();
                
                $table->foreign('Usu_documento')->references('Usu_documento')->on('users')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id('oit_id');
                $table->unsignedBigInteger('ord_id');
                $table->unsignedBigInteger('prod_id');
                $table->integer('oit_cantidad');
                $table->decimal('oit_precio_unitario', 12, 2);
                $table->decimal('oit_subtotal', 12, 2);
                $table->timestamps();
                
                $table->foreign('ord_id')->references('ord_id')->on('orders')->onDelete('cascade');
                $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('cascade');
            });
        }

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
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
