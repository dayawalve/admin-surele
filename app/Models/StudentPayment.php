<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPayment extends Model
{
    use HasFactory;

    protected $table = 'student_payments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'training_program_id',
        'amount',
        'payment_mode',
        'payment_date',
        'remarks',
        'payment_receipt',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
    
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }
}
