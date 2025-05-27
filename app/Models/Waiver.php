<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Waiver extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;
    protected $table = 'waiver'; 
    
    protected $fillable = [
        'date',
        'name',
        'collegeName',
        'department',
        'diagnosedDate',
        'diagnosedIllness',
        'followUpDate',
        'doctorName',
        'document_id',
        'document_type',
        'control_number',
        'revision',
        'date_issued',
        'additional_date',
        'additional_name',
        'additional_collegeName',
        'additional_department',
        'additional_diagnosedDate',
        'additional_diagnosedIllness',
        'additional_followUpDate',
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
        return $this->belongsTo(Document::class, 'document_id');
    }
}