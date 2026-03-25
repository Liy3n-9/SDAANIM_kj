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
        Schema::table('animals', function (Blueprint $table) {
            $table->string('Anim_estado', 50)->change();
            $table->text('Anim_historia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
             $table->enum('Anim_estado', ['Disponible', 'Adoptado', 'En Proceso'])->change();
             $table->text('Anim_historia')->nullable(false)->change();
        });
    }
};
