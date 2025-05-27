<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Supply extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'supply_name',
        'unit',
        'initial_quantity',
        'remaining_quantity',
        'consumed_quantity',
        'expiration_date',
        'status',
        'box_id',
        'user_id'
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
        'initial_quantity' => 'double',
        'consumed_quantity' => 'double',
        'remaining_quantity' => 'double',
        'deleted_at' => 'datetime'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // logs all fillable attributes
            ->useLogName('stock')
            ->logOnlyDirty(); // only logs changes
    }
    /**
     * Get the box that owns the supply.
     */
    public function box(): BelongsTo
    {
        return $this->belongsTo(Boxes::class);
    }

    /**
     * Get the user that owns the supply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
