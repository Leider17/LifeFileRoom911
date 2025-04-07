<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessAttempt extends Model
{
    protected $fillable = ['employee_id', 'success'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
