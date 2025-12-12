<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('disasters', function (Blueprint $table) {
            $table->integer('jumlah_korban')->default(0)->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('disasters', function (Blueprint $table) {
            $table->dropColumn('jumlah_korban');
        });
    }
};
