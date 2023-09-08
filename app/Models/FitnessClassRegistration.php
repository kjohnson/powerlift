<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClassRegistration extends Model
{
    use HasFactory;

    public $fillable = [
        'reference',
        'notes',
    ];

    public function fitnessClassSession()
    {
        return $this->belongsTo(FitnessClassSession::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
