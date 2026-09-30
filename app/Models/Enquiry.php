<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $table = 'enquiries';

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'product',
        'size_qty',
        'message',
        'status',
        'source',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get full name attribute (alias for name)
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }
}
