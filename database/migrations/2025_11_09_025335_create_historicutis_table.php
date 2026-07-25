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
        Schema::create('historicutis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disetuji_oleh')->constrained('karyawans')->onDelete('cascade');
            $table->foreignId('cuti_id')->constrained('cutis')->onDelete('cascade');
            $table->enum('status', ['ajukan', 'setujui', 'tolak', 'ubah']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicutis');
    }
};
