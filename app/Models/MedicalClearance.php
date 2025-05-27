<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class MedicalClearance extends Model
{
    use LogsActivity; // Enables activity logging
    use HasFactory, SoftDeletes; // Enables model factories (optional, remove if not needed)
    protected $table = 'medical_clearances';

    // Fields that can be mass-assigned
    protected $fillable = [
        'document_id', // Foreign key to associate with the Document model
        'document_type',
        'date',
        'patient_name',
        'vaccination_status',
        'excuse',
        'doctorName',
        'position',
        'license_number',
        'xray_result',
        'control_number',
        'revision',
        'date_issued',
        'additional_date',
        'additional_patient_name',
        'additional_vaccination_status',
        'additional_excuse',
        'additional_doctorName',
        'additional_position',
        'additional_license_number',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('document')
            ->logOnlyDirty(); // only logs changes
    }

    // Define the relationship with the Document model
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
