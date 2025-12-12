<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disasters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->string('lokasi');
            $table->enum('status', ['aktif', 'selesai', 'pemulihan']);
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('korbans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disaster_id')->nullable()->constrained('disasters')->onDelete('set null');
            $table->string('nama');
            $table->integer('usia')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('status', ['hilang', 'ditemukan', 'meninggal', 'selamat']);
            $table->string('kebutuhan_medis')->nullable();
            $table->enum('prioritas_medis', ['tinggi', 'sedang', 'rendah'])->default('sedang');
            $table->string('status_medis')->nullable();
            $table->string('kontak_keluarga')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('korban_ditemukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disaster_id')->nullable()->constrained('disasters')->onDelete('set null');
            $table->string('nama');
            $table->enum('identified', ['identified', 'unidentified'])->default('unidentified');
            $table->enum('status_korban', ['selamat', 'luka', 'meninggal'])->default('selamat');
            $table->string('ciri_fisik')->nullable();
            $table->string('barang_bawaan')->nullable();
            $table->string('foto')->nullable();
            $table->string('gps_lokasi')->nullable();
            $table->string('posko_rujukan')->nullable();
            $table->integer('usia')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('lokasi')->nullable();
            $table->string('ciri_ciri')->nullable();
            $table->string('status')->default('ditemukan');
            $table->string('status_medis')->nullable();
            $table->enum('prioritas_medis', ['tinggi', 'sedang', 'rendah'])->default('sedang');
            $table->string('kontak_keluarga')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('korban_hilangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disaster_id')->nullable()->constrained('disasters')->onDelete('set null');
            $table->string('nama');
            $table->integer('usia')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('ciri_fisik')->nullable();
            $table->string('barang_bawaan')->nullable();
            $table->string('kontak_keluarga')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('korbans');
        Schema::dropIfExists('korban_ditemukans');
        Schema::dropIfExists('korban_hilangs');
        Schema::dropIfExists('disasters');
    }
};
