<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Equipment extends Model
{
    use LogsActivity;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'general_description',
        'quantity',
        'quantity_of_request',
        'serviceable',
        'for_repair',
        'for_condemn',
        'need_replacement',
        'additional',
        'user_id'
    ];

    protected $casts = [
        'serviceable' => 'boolean',
        'for_repair' => 'boolean',
        'for_condemn' => 'boolean',
        'need_replacement' => 'boolean',
        'additional' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('stock')
            ->logOnlyDirty(); // only logs changes
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
