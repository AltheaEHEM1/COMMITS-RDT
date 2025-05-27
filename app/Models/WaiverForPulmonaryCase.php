<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class WaiverForPulmonaryCase extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;
    protected $table = 'waiver_for_pulmonary_cases'; 
    
    protected $fillable = [
        'patient_name',
        'collegeName',
        'date',
        'year',
        'followUpDate',
        'document_id',
        'document_type',
        'control_number',
        'revision',
        'date_issued',
        'additional_date',
        'additional_patient_name',
        'additional_collegeName',
        'additional_year',
        'additional_followUpDate',

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
        return $this->belongsTo(Document::class, 'document_id');
    }
}