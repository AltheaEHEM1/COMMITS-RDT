<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ControlNumber extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
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
}
