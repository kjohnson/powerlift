<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static upcoming()
 */
class FitnessClassSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function fitnessClass()
    {
        return $this->belongsTo(FitnessClass::class);
    }

    public function fitnessClassRegistrations()
    {
        return $this->hasMany(FitnessClassRegistration::class);
    }

    public function scopeUpcoming(Builder $query): void
    {
        // @note Query start_time using a regular `where` (not `whereDate`) to preserve the time part of DateTime.
        $query->where('start_time', '>=', Carbon::now());
        $query->where('start_time', '<', Carbon::tomorrow());
    }

    public function scopeFuture(Builder $query): void
    {
        $query->where('start_time', '>=', Carbon::now());
    }
}
