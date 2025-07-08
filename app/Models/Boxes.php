<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Boxes extends Model
{
    use LogsActivity;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_received',
        'stock_number', 
        'isReturned',
        'user_id', // for user relationship
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_received' => 'datetime',
        'isReturned' => 'boolean',
    ];

    /**
     * Get the medicine associated with the box.
     */
    public function medicine()
    {
        return $this->hasOne(Medicine::class, 'box_id');
    }

    /**
     * Get the user that owns the box.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('stock')
            ->logOnlyDirty(); // only logs changes
    }
}
