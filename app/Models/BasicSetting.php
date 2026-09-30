<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BasicSetting extends Model
{
    use HasFactory;
    protected $table = 'basic_settings';
    protected $fillable = [
        'inactivity_threshold',
        'popup_timeout',
        'check_interval',
        'idle_threshold',
        'send_interval',
        'screenshot_enabled',
        'screenshot_count',
        'screenshot_time_period',
        'activity_tracker_enabled',
        'activity_check_interval',
        'blocker_enabled',
        'blocker_check_interval',
    ];
    public $timestamps = true;
}
