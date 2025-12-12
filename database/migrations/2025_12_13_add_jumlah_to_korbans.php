<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('korbans', function (Blueprint $table) {
            $table->integer('jumlah')->default(1)->after('disaster_id');
        });
    }

    public function down(): void
    {
        Schema::table('korbans', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });
    }
};
