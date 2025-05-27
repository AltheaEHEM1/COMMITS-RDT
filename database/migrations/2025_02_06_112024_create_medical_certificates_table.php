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
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('date');
            $table->string('patient_name');
            $table->string('sickness');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('reason');
            $table->string('doctorName');
            $table->string('control_number');
            $table->string('revision');
            $table->date('date_issued'); // Date the control number was issued
            $table->timestamps();
            $table->string('document_type')->default('medical_certificate');
            $table->date('additional_date')->nullable();
            $table->string('additional_patient_name')->nullable();
            $table->string('additional_sickness')->nullable();
            $table->date('additional_startDate')->nullable();
            $table->date('additional_endDate')->nullable();
            $table->string('additional_reason')->nullable();
            $table->string('additional_doctorName')->nullable();
            $table->softDeletes();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
    }
};
