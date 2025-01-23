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
        Schema::create('guardians', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->boolean('gender'); // Kolom untuk jenis kelamin (1: Laki-laki, 0: Perempuan)
            $table->date('birth_date')->nullable(); // Kolom untuk usia
            $table->tinyInteger('income')->nullable(); // Kolom untuk penghasilan (1: <1 juta, 2: 1–4 juta, 3: >=5 juta)
            $table->string('occupation')->nullable(); // Kolom untuk pekerjaan
            $table->string('education')->nullable(); // Kolom untuk tingkat pendidikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
