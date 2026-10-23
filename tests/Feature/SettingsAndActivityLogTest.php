<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class SettingsAndActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_settings_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Administrator');

        $response = $this->actingAs($user)->get('/admin/pengaturan');

        $response->assertOk()->assertSee('Pengaturan');
    }

    public function test_activity_log_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Administrator');

        $response = $this->actingAs($user)->get('/admin/log-aktivitas');

        $response->assertOk()->assertSee('Log Aktivitas');
    }

    public function test_login_is_recorded_in_the_activity_log(): void
    {
        $user = User::factory()->create();

        // /login adalah komponen Livewire Volt, bukan endpoint POST biasa.
        Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password')
            ->call('login');

        $this->assertAuthenticated();

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'auth',
            'description' => 'login',
            'causer_id' => $user->id,
        ]);

        $this->assertSame(1, Activity::where('description', 'login')->count());
    }

    public function test_activity_log_page_is_guest_protected(): void
    {
        $response = $this->get('/admin/log-aktivitas');

        $response->assertRedirect('/login');
    }
}
