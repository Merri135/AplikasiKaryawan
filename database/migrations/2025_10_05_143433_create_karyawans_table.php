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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('IdBadge', 16)->unique();
            $table->string('jabatan', 50);
            $table->date('join_date');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->onDelete('set null');
            $table->string('no_hp', 12)->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
