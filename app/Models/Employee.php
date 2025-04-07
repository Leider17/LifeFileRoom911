<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\AccessAttempt;

class Employee extends Model
{
    protected $fillable = ['internal_id', 'first_name', 'last_name', 'department_id', 'has_access'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function accessAttempts()
    {
        return $this->hasMany(AccessAttempt::class);
    }
}
