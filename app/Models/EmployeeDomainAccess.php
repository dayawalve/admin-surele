<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDomainAccess extends Model
{
    use HasFactory;
    protected $table= 'employee_domain_access';
    public $primaryKey='id';
    public $timestamp= true;

    protected $fillable = [
        'employee_id',
        'domain_id',
        'is_enabled',
    ];

}
