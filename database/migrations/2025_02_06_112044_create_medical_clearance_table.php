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
        Schema::create('medical_clearances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('date');
            $table->string('patient_name');
            $table->string('vaccination_status');  
            $table->string('excuse');
            $table->string('position');
            $table->string('license_number');
            $table->string('control_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('date_issued')->nullable();
            $table->timestamps();
            $table->string('doctorName');
            $table->string('xray_result')->nullable();
            $table->string('additional_doctorName')->nullable();
            $table->string('document_type')->default('medical_clearance');
            $table->date('additional_date')->nullable();
            $table->string('additional_patient_name')->nullable();
            $table->string('additional_vaccination_status')->nullable();
            $table->string('additional_excuse')->nullable();
            $table->string('additional_position')->nullable();
            $table->string('additional_license_number')->nullable();
            $table->softDeletes();
        
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_clearance');
    }
};
