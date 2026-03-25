<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->dateTime('Hist_fecha')->nullable()->after('Usu_documento');
            $table->text('Hist_diagnostico')->nullable()->after('Hist_fecha');
            $table->text('Hist_tratamiento')->nullable()->after('Hist_diagnostico');
            $table->text('Hist_observaciones')->nullable()->after('Hist_tratamiento');
        });
    }

    public function down(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->dropColumn(['Hist_fecha', 'Hist_diagnostico', 'Hist_tratamiento', 'Hist_observaciones']);
        });
    }
};
