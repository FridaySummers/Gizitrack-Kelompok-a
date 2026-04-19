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
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_tujuan');
            $table->integer('jumlah_porsi');
            $table->date('tanggal_pengiriman');
            $table->enum('status', ['Pending', 'Di Perjalanan', 'Terkirim', 'Diterima', 'Diterima Sebagian', 'Kendala'])->default('Pending');
            $table->text('catatan_kendala')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
