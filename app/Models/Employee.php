<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    public function screenshots()
    {
        return $this->hasMany(Screenshot::class, 'employee_id', 'employee_code');
    }
}
