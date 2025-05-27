<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends Model
{   
    use LogsActivity;
    use SoftDeletes;
    protected $table = 'reports';

    protected $fillable = [
        'title', 
        'name', 
        'age', 
        'sex', 
        'complaint', 
        'diagnosis', 
        'remarks', 
        'category',
        'date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('report')
            ->logOnlyDirty(); // only logs changes
    }

}