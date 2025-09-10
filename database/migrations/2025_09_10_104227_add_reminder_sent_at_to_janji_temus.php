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
        Schema::table('janji_temus', function (Blueprint $t) {
            $t->timestamp('reminder_sent_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('janji_temus', function (Blueprint $t) {
            $t->dropColumn('reminder_sent_at');
        });
    }
};
