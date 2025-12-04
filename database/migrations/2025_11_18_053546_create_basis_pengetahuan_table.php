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
    Schema::create('basis_pengetahuans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kerusakan_id')->constrained()->onDelete('cascade');
        $table->foreignId('gejala_id')->constrained()->onDelete('cascade');
        $table->float('bobot', 8, 2); // 0-1
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basis_pengetahuan');
    }
};
