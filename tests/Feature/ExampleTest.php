<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_authenticated_user_sees_home(): void
    {
        $this->actingAs(User::factory()->create())->get('/')->assertOk();
    }

    public function test_regular_user_cannot_open_gated_pengaturan_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get('/pengaturan/master-data')
            ->assertForbidden();
    }

    public function test_superadmin_can_open_pengaturan_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']))
            ->get('/pengaturan/master-data')
            ->assertOk();
    }
}
