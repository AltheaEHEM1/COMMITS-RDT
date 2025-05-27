<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class MedicalCertificate extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;
    
    protected $table = 'medical_certificates';

    protected $fillable = [
        'document_id',
        'date',
        'patient_name',
        'sickness',
        'startDate',
        'endDate',
        'reason',
        'doctorName',
        'document_type',
        'control_number',
        'revision',
        'date_issued',
        'additional_date',
        'additional_patient_name',
        'additional_sickness',
        'additional_startDate',
        'additional_endDate',
        'additional_reason',
        'additional_doctorName',
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