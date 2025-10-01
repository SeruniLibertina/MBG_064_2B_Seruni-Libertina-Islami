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
            Schema::create('bahan_bakus', function (Blueprint $table) {
                $table->id(); // Ini untuk kolom `id`
                $table->string('nama', 120); // Ini untuk `nama` VARCHAR(120) 
                $table->string('kategori', 60); // Ini untuk `kategori` VARCHAR(60) 
                $table->integer('jumlah'); // Ini untuk `jumlah` INT 
                $table->string('satuan', 20); // Ini untuk `satuan` VARCHAR(20) 
                $table->date('tanggal_masuk'); // Ini untuk `tanggal_masuk` DATE 
                $table->date('tanggal_kadaluarsa'); // Ini untuk `tanggal_kadaluarsa` DATE 
                $table->enum('status', ['tersedia', 'segera_kadaluarsa', 'kadaluarsa', 'habis']); // Ini untuk `status` ENUM 
                $table->timestamps(); // Ini untuk `created_at` dan `updated_at`
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
