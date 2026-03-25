<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Usu_documento');
            $table->date('Ava_date');
            $table->time('Ava_start_time');
            $table->time('Ava_end_time');
            $table->string('Ava_status')->default('Disponible');
            $table->foreign('Usu_documento')->references('Usu_documento')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
