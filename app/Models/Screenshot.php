<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screenshot extends Model
{
    protected $table = 'screenshots';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'ip_address',
        'screenshot_path',
        'date_time',
    ];
}

