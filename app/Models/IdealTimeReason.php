<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdealTimeReason extends Model
{
    use HasFactory;

    protected $table = 'ideal_time_reasons';

    protected $fillable = [
        'employee_id',
        'ideal_start_time',
        'ideal_end_time',
        'total_seconds',
        'reason',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
