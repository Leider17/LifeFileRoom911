<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessAttempt>
 */
class AccessAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $employee=Employee::inRandomOrder()->first() ?? Employee::factory();
        return [
            'employee_id'=>$employee->id,
            'success'=>$employee->has_access ? true: false,
        ];
    }
}
