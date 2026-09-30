<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherRefer extends Model
{
    use HasFactory;
    protected $table= 'other_refers';
    public $primaryKey='id';
    protected $fillable = [
        'student_id',
        'name',
    ];
    public $timestamp= true;
}

