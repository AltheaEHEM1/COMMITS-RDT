<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Excuseletter extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;
    protected $table = 'excuseletter'; 
    
    protected $fillable = [
        'document_type',
        'date', 
        'recipient', 
        'patient_name', 
        'department', 
        'excuse_for', 
        'cause', 
        'doctorName',
        'document_id',
        'control_number',
        'revision',
        'd;ate_issued',
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