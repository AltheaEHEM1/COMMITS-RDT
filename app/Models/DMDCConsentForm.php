<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class DMDCConsentForm extends Model
{
    use LogsActivity; // Enables activity logging
    use HasFactory, SoftDeletes; // Enables model factories (optional, remove if not needed)
    protected $table = 'dmdc_consent_forms';

    protected $fillable = [
        'document_id',
        'event_name',
        'document_type',
        'control_number',
        'revision',
        'date_issued',
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