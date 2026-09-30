<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'college_id',
        'image',
        'is_active',
        'is_deleted',
    ];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'student_id');
    }

    public function referredBy()
    {
        return $this->belongsTo(Students::class, 'refer_by_id');
    }

    public function referrals()
    {
        return $this->hasMany(Students::class, 'refer_by_id');
    }

    public function bd()
    {
        return $this->belongsTo(BusinessDeveloper::class, 'bd_id');
    }

    public function otherRefer()
    {
        return $this->hasOne(OtherRefer::class, 'student_id');
    }



}