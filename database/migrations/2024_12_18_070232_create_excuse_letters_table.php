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
        Schema::create('excuseletter', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('document_id'); // Foreign key to the documents table
            $table->date('date'); // The date for the excuse letter
            $table->string('recipient'); // Recipient of the excuse letter
            $table->string('patient_name'); // Name of the patient
            $table->string('department');
            $table->date('excuse_for'); // Date the excuse applies to
            $table->string('cause'); // Reason for the excuse
            $table->string('doctorName');
            $table->string('document_type');
            $table->string('control_number');
            $table->string('revision');
            $table->date('date_issued'); // Date the contruct was issued
            $table->timestamps(); // created_at and updated_at columns
            $table->softDeletes();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excuseletter');
    }
};
