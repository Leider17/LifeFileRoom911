<?php

namespace App\Models;

use App\Models\AccessAttempt;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
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
