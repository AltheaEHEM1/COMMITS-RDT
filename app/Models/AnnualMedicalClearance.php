<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AnnualMedicalClearance extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes; // Enables model factories (optional, remove if not needed)
    protected $table = 'annual_medical_clearances';

    protected $fillable = [
        'document_id',
        'date',
        'patient_name',
        'excuseDate',
        'doctorName',
        'license_number',
        'document_type',
        'control_number',
        'revision',
        'date_issued',
        'additional_date',
        'additional_patient_name',
        'additional_excuse_date',
        'additional_doctorName',
        'additional_license_number',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('document')
            ->logOnlyDirty(); // only logs changes
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}