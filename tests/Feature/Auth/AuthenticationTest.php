<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Administrator');

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $this->get(route('dashboard'))
            ->assertRedirect(route('admin.index', absolute: false));
    }

    public function test_tim_pelayanan_diarahkan_ke_pelayanan(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('pelayanan.index', absolute: false));
    }

    public function test_user_biasa_diarahkan_ke_home(): void
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password')
            ->call('login')
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $this->get(route('dashboard'))
            ->assertRedirect(route('home', absolute: false));
    }

    public function test_user_biasa_tidak_bisa_membuka_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('home', absolute: false));
    }

    public function test_user_biasa_tidak_melihat_menu_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertDontSee('Dashboard');
    }

    public function test_admin_melihat_menu_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Administrator');

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_navigation_menu_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Administrator');

        $this->actingAs($user);

        $response = $this->get(route('admin.index'));

        $response
            ->assertOk()
            ->assertSee('GKKD BALI')
            ->assertSee('Dashboard Overview');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
