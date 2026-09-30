<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawStudent extends Model
{
    protected $fillable = [
        'name',
        'address',
        'dob',
        'education',
        'preferred_technology',
        'phone',
        'email',
        'college',
        'job_assurance',
        'is_mailsend'
    ];
}

