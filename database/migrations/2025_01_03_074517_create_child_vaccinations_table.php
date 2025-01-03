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
        Schema::create('child_vaccinations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('child_id');
            $table->ulid('vaccine_id')->nullable();
            $table->date('vaccine_date');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_vaccinations');
    }
};
