<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeveloperDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_developer_can_access_the_dashboard(): void
    {
        $developer = User::factory()->create([
            'role' => 'developer',
        ]);

        $response = $this->actingAs($developer)->get('/developer/dashboard');

        $response->assertOk();
        $response->assertSee('Developer dashboard');
    }

    public function test_non_developer_cannot_access_the_dashboard(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $response = $this->actingAs($client)->get('/developer/dashboard');

        $response->assertForbidden();
    }
}
