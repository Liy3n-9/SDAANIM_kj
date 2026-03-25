<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('Noti_link', 255)->nullable()->after('Noti_mensaje');
            $table->timestamp('read_at')->nullable()->after('Noti_fecha');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['Noti_link', 'read_at']);
        });
    }
};
