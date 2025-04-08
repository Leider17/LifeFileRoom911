<?php

namespace Tests\Feature;

use App\Models\AdminRoomUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get('/employees/index');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_employees_index()
    {
        $user = AdminRoomUser::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/employees/index');
        $response->assertStatus(200);
    }
}
