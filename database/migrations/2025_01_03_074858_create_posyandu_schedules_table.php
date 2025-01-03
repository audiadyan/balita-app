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
        Schema::create('posyandu_schedules', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->ulid('vaccine_id')->nullable();
            $table->string('location');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('vaccine_id')->references('id')->on('vaccines')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_schedules');
    }
};
