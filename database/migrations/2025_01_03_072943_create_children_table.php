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
        Schema::create('children', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('mother_id')->nullable();
            $table->ulid('father_id')->nullable();
            $table->string('name');
            $table->date('birth_date');
            $table->boolean('gender');
            $table->timestamps();

            $table->foreign('mother_id')->references('id')->on('guardians')->nullOnDelete();
            $table->foreign('father_id')->references('id')->on('guardians')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
