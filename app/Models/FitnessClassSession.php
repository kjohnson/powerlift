<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClassSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:i',
        'end_time' => 'datetime:Y-m-d H:i',
    ];

    public function fitnessClass()
    {
        return $this->belongsTo(FitnessClass::class);
    }

    public function fitnessClassRegistrations()
    {
        return $this->hasMany(FitnessClassRegistration::class);
    }
}
