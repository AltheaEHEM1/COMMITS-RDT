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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name', 100);
            $table->string('unit', 100); 
            $table->double('initial_quantity'); // Add precision and scale
            $table->double('consumed_quantity')->default(0); // Add default
            $table->double('remaining_quantity'); // Add precision and scale
            $table->dateTime('expiration_date');
            $table->foreignId('box_id')->constrained()->onDelete('cascade');
            $table->string('status', 50); // Corrected `Status`
            $table->softDeletes();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('notified_quarterly')->default(false);
            $table->boolean('notified_monthly')->default(false);
            $table->boolean('notified_weekly')->default(false);
            $table->boolean('notified_today')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};