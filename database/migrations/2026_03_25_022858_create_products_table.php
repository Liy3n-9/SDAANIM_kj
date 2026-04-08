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
            $table->id('prod_id');
            $table->string('prod_nombre', 100);
            $table->text('prod_descripcion')->nullable();
            $table->enum('prod_categoria', ['Alimentos', 'Juguetes', 'Camas', 'Accesorios', 'Ropa']);
            $table->decimal('prod_precio', 10, 2);
            $table->integer('prod_cantidad')->default(0);
            $table->string('prod_imagen', 255)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
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
