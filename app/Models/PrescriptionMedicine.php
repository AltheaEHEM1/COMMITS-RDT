<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PrescriptionMedicine extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;

    protected $table = 'prescription_medicine';

    protected $fillable = [
        'patient_id',
        'medicine_id',
        'quantity'
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('patient')
            ->logOnlyDirty(); // only logs changes
    }

    /**
     * Get the patient that owns the prescription medicine.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the medicine associated with the prescription.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class)->withTrashed(); // Add withTrashed if using soft deletes
    }

    /**
     * Get the prescription that owns the prescription medicine.
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}