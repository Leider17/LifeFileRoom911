<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_id'=>Str::random(6),
            'first_name'=>$this->faker->firstName,
            'last_name'=>$this->faker->lastName,
            'department_id'=>Department::inRandomOrder()->first()?->id ?? Department::factory()
        ];
    }
}
