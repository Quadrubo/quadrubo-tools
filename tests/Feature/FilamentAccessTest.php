<?php

namespace Tests\Feature;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilamentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class RoleSeeder');
        $this->artisan('db:seed --class PermissionSeeder');
        $this->artisan('db:seed --class RoleHasPermissionsSeeder');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authorized_user_can_access_filament()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $user->givePermissionTo('access_filament');

        // Execute
        $response = $this->get('/admin');

        // Test
        $response->assertStatus(200);
    }

    public function test_unauthorized_user_can_not_access_filament()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        // Execute
        $response = $this->get('/admin');

        // Test
        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
    }
}
