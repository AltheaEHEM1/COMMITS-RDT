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
        Schema::create('dmdc_consent_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('event_name');
            $table->timestamps();
            $table->string('control_number')->nullable();
            $table->string('revision')->nullable();
            $table->date('date_issued')->nullable();
            $table->string('document_type')->default('dmdc_consent_form');
            $table->softDeletes();
        
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmdc_consent_form');
    }
};
