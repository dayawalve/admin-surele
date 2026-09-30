<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class College extends Model
{
    use HasFactory;

    protected $table = 'colleges';
    public $timestamps = true;

    public function students()
    {
        return $this->hasMany(Students::class, 'college_id', 'id');
    }
}
