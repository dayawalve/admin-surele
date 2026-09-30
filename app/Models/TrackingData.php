<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrackingData extends Model
{
    use HasFactory;
    protected $table = 'tracking_data';
    protected $fillable = [
        'employee_id',
        'date_time',
        'activity_date',
        'active_tabs',
        'active_tabs_time',
    ];
    
    protected $casts = [
        'date_time' => 'datetime',
        'activity_date' => 'date',
        'active_tabs_time' => 'integer',
    ];

    public $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
