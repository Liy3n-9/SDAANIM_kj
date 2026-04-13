<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('adoption_reviews')) {
            Schema::create('adoption_reviews', function (Blueprint $table) {
                $table->id('rev_id');
                $table->unsignedBigInteger('soli_id'); // referencia a la solicitud
                $table->string('Usu_documento', 20);   // quien califica
                $table->tinyInteger('rev_estrellas');   // 1–5
                $table->text('rev_comentario')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_reviews');
    }
};
