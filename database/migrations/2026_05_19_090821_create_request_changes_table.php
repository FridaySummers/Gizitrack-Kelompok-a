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
        Schema::create('request_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribusi_id')->constrained('distribusis')->onDelete('cascade');
            $table->integer('jumlah_porsi_awal');
            $table->integer('jumlah_porsi_baru');
            $table->text('alasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_changes');
    }
};
