<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;
class Patient extends Model
{
    use LogsActivity;
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'lastName',
        'firstName',
        'middleName',
        'sex',
        'year_course_dept',
        'contactDetails',
        'patient_status',
        'patientType',
        'student_number',
        'physician_id',
    ];

    // for fuzzy search
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'full_name' => "{$this->firstName} {$this->middleName} {$this->lastName}",
        ];
    }
    
    /**
     * Validation rules for patient data
     * 
     * @return array
     */
    public static function validationRules()
    {
        return [
            'lastName' => 'required|string|max:100',
            'firstName' => 'required|string|max:100',
            'middleName' => 'nullable|string|max:100',
            'sex' => 'required|in:Male,Female',
            'year_course_dept' => 'required|string|max:255',
            'contactDetails' => 'required|string|max:255',
            'patient_status' => 'required|string',
            'patientType' => 'required|in:Student,Faculty,Admin,Visitor,Dependent',
            'student_number' => 'nullable|required_if:patientType,Student|string|max:255',
            'physician_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Custom validation messages for patient data
     * 
     * @return array
     */
    public static function validationMessages()
    {
        return [
            'lastName.required' => 'Last name is required',
            'firstName.required' => 'First name is required',
            'sex.required' => 'Sex is required',
            'sex.in' => 'Sex must be either Male or Female',
            'contactDetails.required' => 'Contact information is required',
            'patient_status.required' => 'Patient status is required',
            'patientType.required' => 'Patient type is required',
            'patientType.in' => 'Patient type must be one of the allowed types',
            'physician_id.required' => 'A physician must be assigned to the patient',
            'physician_id.exists' => 'The selected physician is not valid',
            'student_number.required_if' => 'Student number is required for student patients',
            'year_course_dept.required' => 'Year/Course/Department information is required'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('patient')
            ->logOnlyDirty(); // only logs changes
    }
    /**
     * Get full name attribute
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->lastName . ', ' . $this->firstName . ' ' . ($this->middleName ? $this->middleName : '');
    }

    /**
     * Get the physician associated with the patient.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function physician()
    {
        return $this->belongsTo(User::class, 'physician_id');
    }

    /**
     * Get all prescriptions for the patient.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    /**
     * Get all medicines prescribed to the patient.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}