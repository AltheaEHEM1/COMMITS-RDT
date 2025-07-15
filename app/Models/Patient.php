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

    /**
     * Check if a patient with exact same name already exists
     */
    public static function hasExactDuplicate($firstName, $middleName, $lastName, $patientType = null, $studentNumber = null)
    {
        // Check for exact name match first
        $nameQuery = static::query()
            ->whereRaw('LOWER(TRIM(firstName)) = ?', [strtolower(trim($firstName))])
            ->whereRaw('LOWER(TRIM(lastName)) = ?', [strtolower(trim($lastName))])
            ->whereRaw('LOWER(TRIM(COALESCE(middleName, ""))) = ?', [strtolower(trim($middleName ?? ''))]);
        
        if ($nameQuery->exists()) {
            return true;
        }
        
        // If patient type is Student, also check for exact student number match
        if ($patientType === 'Student' && !empty($studentNumber)) {
            $studentQuery = static::query()
                ->where('patientType', 'Student')
                ->whereRaw('LOWER(TRIM(student_number)) = ?', [strtolower(trim($studentNumber))]);
                
            if ($studentQuery->exists()) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the type of exact duplicate found
     */
    public static function getExactDuplicateType($firstName, $middleName, $lastName, $patientType = null, $studentNumber = null)
    {
        // Check for exact name match first
        $nameQuery = static::query()
            ->whereRaw('LOWER(TRIM(firstName)) = ?', [strtolower(trim($firstName))])
            ->whereRaw('LOWER(TRIM(lastName)) = ?', [strtolower(trim($lastName))])
            ->whereRaw('LOWER(TRIM(COALESCE(middleName, ""))) = ?', [strtolower(trim($middleName ?? ''))]);
        
        $nameExists = $nameQuery->exists();
        
        // If patient type is Student, also check for exact student number match
        $studentNumberExists = false;
        if ($patientType === 'Student' && !empty($studentNumber)) {
            $studentQuery = static::query()
                ->where('patientType', 'Student')
                ->whereRaw('LOWER(TRIM(student_number)) = ?', [strtolower(trim($studentNumber))]);
                
            $studentNumberExists = $studentQuery->exists();
        }
        
        if ($nameExists && $studentNumberExists) {
            return 'both'; // Both name and student number exist
        } elseif ($nameExists) {
            return 'name'; // Only name exists
        } elseif ($studentNumberExists) {
            return 'student_number'; // Only student number exists
        }
        
        return false; // No duplicates found
    }

    /**
     * Find patients with similar names (for warnings)
     */
    public static function findSimilarNames($firstName, $middleName, $lastName, $patientType = null, $studentNumber = null)
    {
        $query = trim(implode(' ', array_filter([$firstName, $middleName, $lastName])));
        
        if (empty($query)) {
            return collect();
        }
        
        try {
            $results = static::search($query)->get();
            
            // If patient type is Student, also check for similar student numbers
            if ($patientType === 'Student' && !empty($studentNumber)) {
                $studentNumberResults = static::where('patientType', 'Student')
                    ->where('student_number', 'LIKE', '%' . $studentNumber . '%')
                    ->whereRaw('LOWER(TRIM(student_number)) != ?', [strtolower(trim($studentNumber))]) // Exclude exact matches
                    ->get();
                
                // Merge and remove duplicates
                $results = $results->merge($studentNumberResults)->unique('id');
            }
            
            // Filter out exact duplicates from similar results
            $results = $results->filter(function ($patient) use ($firstName, $middleName, $lastName, $patientType, $studentNumber) {
                $exactNameMatch = (
                    strtolower(trim($patient->firstName)) === strtolower(trim($firstName)) &&
                    strtolower(trim($patient->lastName)) === strtolower(trim($lastName)) &&
                    strtolower(trim($patient->middleName ?? '')) === strtolower(trim($middleName ?? ''))
                );
                
                $exactStudentMatch = false;
                if ($patientType === 'Student' && !empty($studentNumber) && $patient->patientType === 'Student') {
                    $exactStudentMatch = strtolower(trim($patient->student_number ?? '')) === strtolower(trim($studentNumber));
                }
                
                // Exclude exact matches from similar results
                return !($exactNameMatch || $exactStudentMatch);
            });
            
            return $results;
        } catch (\Throwable $e) {
            // Fallback to database search if Meilisearch fails
            $query = static::query()
                ->where(function ($q) use ($firstName, $lastName) {
                    $q->whereRaw('LOWER(firstName) LIKE ?', ['%' . strtolower($firstName) . '%'])
                    ->orWhereRaw('LOWER(lastName) LIKE ?', ['%' . strtolower($lastName) . '%']);
                });
                
            // Add student number check for fallback as well (excluding exact matches)
            if ($patientType === 'Student' && !empty($studentNumber)) {
                $query->orWhere(function ($q) use ($studentNumber) {
                    $q->where('patientType', 'Student')
                    ->where('student_number', 'LIKE', '%' . $studentNumber . '%')
                    ->whereRaw('LOWER(TRIM(student_number)) != ?', [strtolower(trim($studentNumber))]);
                });
            }
            
            // Filter out exact name matches from fallback results
            $query->where(function ($q) use ($firstName, $middleName, $lastName) {
                $q->whereRaw('NOT (LOWER(TRIM(firstName)) = ? AND LOWER(TRIM(lastName)) = ? AND LOWER(TRIM(COALESCE(middleName, ""))) = ?)', 
                    [strtolower(trim($firstName)), strtolower(trim($lastName)), strtolower(trim($middleName ?? ''))]);
            });
            
            return $query->get();
        }
    }
}