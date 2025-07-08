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
        Schema::create('annual_medical_clearances', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('document_id'); // Foreign key to the documents table
            $table->date('date'); // Date of the medical clearance
            $table->string('patient_name'); // Name of the patient
            $table->date('excuseDate'); // Start date of the clearance
            $table->string('doctorName'); // Name of the doctor
            $table->string('license_number'); // Doctor's license number
            $table->string('control_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('date_issued')->nullable();
            $table->timestamps(); // Created at and updated at timestamps
            $table->string('document_type')->default('annual_medical_clearance'); // Document type
            $table->date('additional_date')->nullable(); // Additional date
            $table->string('additional_patient_name')->nullable(); // Additional patient name
            $table->date('additional_excuse_date')->nullable(); // Additional excuse date
            $table->string('additional_doctorName')->nullable(); // Additional doctor name
            $table->string('additional_license_number')->nullable(); // Additional doctor's license number
            // Foreign key constraint
            $table->softDeletes();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_medical_clearances');
    }
};