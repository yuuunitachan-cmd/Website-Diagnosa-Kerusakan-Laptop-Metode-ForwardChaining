<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('histories', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pengguna');
        $table->string('email')->nullable();
        $table->json('gejala_terpilih'); 
        $table->json('hasil_diagnosa');  
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
