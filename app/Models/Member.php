<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_id',
    ];

    protected $hidden = [
        'pin',
    ];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
}
