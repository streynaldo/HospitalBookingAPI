<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('janji_temus', function (Blueprint $table) {
            $table->enum('tipe_pasien', ['diri_sendiri', 'orang_lain'])
                ->default('diri_sendiri')
                ->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('janji_temus', function (Blueprint $table) {
            $table->dropColumn('tipe_pasien');
        });
    }
};
