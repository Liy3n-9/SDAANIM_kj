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
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->enum('Soli_estado', ['Pendiente', 'En Revisión', 'Aceptada', 'Rechazada'])->default('Pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->enum('Soli_estado', ['Pendiente', 'Asignada', 'En Entrevista', 'Aprobada', 'No Apta', 'Proceso Adopcion', 'Rechazada'])->default('Pendiente')->change();
        });
    }
};
