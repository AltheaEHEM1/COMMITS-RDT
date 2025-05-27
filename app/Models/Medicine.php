<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medicine_name',
        'unit',
        'initial_quantity',
        'consumed_quantity',
        'remaining_quantity',
        'expiration_date',
        'box_id',
        'status',
        'user_id',
        'notified_quarterly',
        'notified_monthly',
        'notified_weekly',
        'notified_today'
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
        'initial_quantity' => 'double',
        'remaining_quantity' => 'double',
        'consumed_quantity' => 'double',
        'deleted_at' => 'datetime',
        'notified_quarterly' => 'boolean',
        'notified_monthly' => 'boolean',
        'notified_weekly' => 'boolean',
        'notified_today' => 'boolean'
    ];

    protected $table = 'medicines';

    // Relationships
    public function box()
    {
        return $this->belongsTo(Boxes::class, 'box_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all prescriptions for this medicine.
     */
    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('stock')
            ->logOnlyDirty(); // only logs changes
    }
    /**
     * Get all patients who have been prescribed this medicine.
     */
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'prescription_medicine')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
