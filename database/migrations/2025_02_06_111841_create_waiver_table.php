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
        Schema::create('waiver', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('date');
            $table->string('name');
            $table->string('collegeName');
            $table->string('department');
            $table->date('diagnosedDate');
            $table->string('diagnosedIllness');
            $table->date('followUpDate');
            $table->string('doctorName');
            $table->string('control_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('date_issued')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('document_type')->default('waiver');
            $table->date('additional_date')->nullable();
            $table->string('additional_name')->nullable();
            $table->string('additional_collegeName')->nullable();
            $table->string('additional_department')->nullable();
            $table->date('additional_diagnosedDate')->nullable();
            $table->string('additional_diagnosedIllness')->nullable();
            $table->date('additional_followUpDate')->nullable();
            $table->string('additional_doctorName')->nullable();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiver');
    }
};
