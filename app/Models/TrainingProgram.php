<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingProgram extends Model
{
    protected $fillable = [
        'program_code',
        'program_name',
        'description',
        'duration_weeks',
        'training_mode',
        'fees',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Students::class, 'training_program_id')->where('is_deleted', 0);
    }

}
