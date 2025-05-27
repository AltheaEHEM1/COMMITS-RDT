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
        Schema::create('control_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('document_type');
            $table->string('control_number')->unique();
            $table->string('revision');
            $table->date('date_issued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_numbers');
    }
};
