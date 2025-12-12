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
        Schema::create('quick_reports', function (Blueprint $table) {
            $table->id();
            $table->string('foto_path')->nullable();
            $table->integer('jumlah_korban')->default(0);
            $table->string('lokasi');
            $table->dateTime('waktu')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_reports');
    }
};
