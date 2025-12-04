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
    Schema::create('kerusakans', function (Blueprint $table) {
        $table->id();
        $table->string('kode_kerusakan')->unique();
        $table->string('nama_kerusakan');
        $table->text('deskripsi');
        $table->text('solusi');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerusakans');
    }
};
