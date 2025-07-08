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
        Schema::create('waiver_for_pulmonary_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('patient_name');
            $table->string('collegeName');
            $table->string('year');
            $table->date('followUpDate');
            $table->date('date');
            $table->string('control_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('date_issued')->nullable();
            $table->timestamps();
            $table->string('document_type')->default('waiver_for_pulmonary_cases');
            $table->string('additional_patient_name')->nullable();
            $table->string('additional_collegeName')->nullable();
            $table->date('additional_date')->nullable();
            $table->string('additional_year')->nullable();
            $table->softDeletes();
            $table->date('additional_followUpDate')->nullable();
        
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiver_for_pulmonary_cases');
    }
};
