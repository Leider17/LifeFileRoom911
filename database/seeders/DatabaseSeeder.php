<?php

namespace Database\Seeders;

use App\Models\AccessAttempt;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        Department::factory(5)->create();
        Employee::factory(30)->create();

        AccessAttempt::factory(100)->create();

    }
}
