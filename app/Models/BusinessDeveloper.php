<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessDeveloper extends Model
{
    use HasFactory;

    protected $table = 'business_developers';
    protected $fillable = ['name', 'email', 'phone', 'extra_emails', 'is_active'];
    public $timestamps = true;

    public function students()
    {
        return $this->hasMany(Students::class, 'bd_id');
    }
}


