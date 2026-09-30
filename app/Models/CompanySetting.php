<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanySetting extends Model
{
    use HasFactory;
    protected $table = 'company_settings';
    public $timestamps = true;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_website',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'logo',
        'favicon',
        'gst_number',
        'pan_number',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'is_active',
    ];
}
