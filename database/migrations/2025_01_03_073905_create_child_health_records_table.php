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
        Schema::create('child_health_records', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('child_id');
            $table->date('record_date');
            $table->float('weight')->comment('in KG');
            $table->float('height')->comment('in CM');
            $table->float('bmi');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_health_records');
    }
};
