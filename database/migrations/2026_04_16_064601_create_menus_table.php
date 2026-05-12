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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            
            // PBI-30: Menghubungkan menu dengan vendor yang membuatnya
            $table->foreignId('vendor_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('name');
            $table->text('description');
            $table->integer('calories');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};