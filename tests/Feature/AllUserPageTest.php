<?php

namespace Tests\Feature;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllUserPageTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Administrator');
    }

    public function test_halaman_dapat_diakses_oleh_administrator(): void
    {
        $this->actingAs($this->admin)
            ->get(route('all-user'))
            ->assertOk()
            ->assertSeeText('Daftar Pengguna');
    }

    public function test_halaman_ditolak_untuk_user_bukan_administrator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Staff');

        $this->actingAs($user)
            ->get(route('all-user'))
            ->assertForbidden();
    }

    public function test_halaman_dilindungi_dari_tamu(): void
    {
        $this->get(route('all-user'))
            ->assertRedirect('/login');
    }

    public function test_menampilkan_seluruh_user(): void
    {
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Budi Google', 'email' => 'budi.google@example.com']);
        User::factory()->has(SocialAccount::factory()->facebook())->create(['name' => 'Sari Facebook', 'email' => 'sari.facebook@example.com']);
        User::factory()->create(['name' => 'Wayan Lokal', 'email' => 'wayan.lokal@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user'))
            ->assertOk()
            ->assertSeeText('Budi Google')
            ->assertSeeText('Sari Facebook')
            ->assertSeeText('Wayan Lokal');
    }

    public function test_pencarian_berdasarkan_nama_dan_email(): void
    {
        User::factory()->create(['name' => 'Made Wardana', 'email' => 'made@example.com']);
        User::factory()->create(['name' => 'Ketut Sari', 'email' => 'ketut@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['q' => 'wardana']))
            ->assertOk()
            ->assertSeeText('Made Wardana')
            ->assertDontSeeText('Ketut Sari');

        $this->actingAs($this->admin)
            ->get(route('all-user', ['q' => 'ketut@example.com']))
            ->assertOk()
            ->assertSeeText('Ketut Sari')
            ->assertDontSeeText('Made Wardana');
    }

    public function test_filter_provider_google(): void
    {
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Budi Google', 'email' => 'budi.google@example.com']);
        User::factory()->has(SocialAccount::factory()->facebook())->create(['name' => 'Sari Facebook', 'email' => 'sari.facebook@example.com']);
        User::factory()->create(['name' => 'Wayan Lokal', 'email' => 'wayan.lokal@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['provider' => 'google']))
            ->assertOk()
            ->assertSeeText('Budi Google')
            ->assertDontSeeText('Sari Facebook')
            ->assertDontSeeText('Wayan Lokal');
    }

    public function test_filter_provider_facebook(): void
    {
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Budi Google', 'email' => 'budi.google@example.com']);
        User::factory()->has(SocialAccount::factory()->facebook())->create(['name' => 'Sari Facebook', 'email' => 'sari.facebook@example.com']);
        User::factory()->create(['name' => 'Wayan Lokal', 'email' => 'wayan.lokal@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['provider' => 'facebook']))
            ->assertOk()
            ->assertSeeText('Sari Facebook')
            ->assertDontSeeText('Budi Google')
            ->assertDontSeeText('Wayan Lokal');
    }

    public function test_filter_provider_lokal(): void
    {
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Budi Google', 'email' => 'budi.google@example.com']);
        User::factory()->create(['name' => 'Wayan Lokal', 'email' => 'wayan.lokal@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['provider' => 'lokal']))
            ->assertOk()
            ->assertSeeText('Wayan Lokal')
            ->assertDontSeeText('Budi Google');
    }

    public function test_user_multi_provider_muncul_di_filter_google_dan_facebook(): void
    {
        // Satu user terhubung Google + Facebook sekaligus.
        $user = User::factory()
            ->has(SocialAccount::factory()->google())
            ->has(SocialAccount::factory()->facebook())
            ->create(['name' => 'Andi Multi', 'email' => 'andi.multi@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['provider' => 'google']))
            ->assertOk()
            ->assertSeeText('Andi Multi');

        $this->actingAs($this->admin)
            ->get(route('all-user', ['provider' => 'facebook']))
            ->assertOk()
            ->assertSeeText('Andi Multi');

        $this->assertSame(2, $user->fresh()->socialAccounts()->count());
    }

    public function test_filter_kombinasi_pencarian_dan_provider(): void
    {
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Budi Google', 'email' => 'budi.google@example.com']);
        User::factory()->has(SocialAccount::factory()->google())->create(['name' => 'Sari Google', 'email' => 'sari.google@example.com']);
        User::factory()->has(SocialAccount::factory()->facebook())->create(['name' => 'Budi Facebook', 'email' => 'budi.facebook@example.com']);

        $this->actingAs($this->admin)
            ->get(route('all-user', ['q' => 'budi', 'provider' => 'google']))
            ->assertOk()
            ->assertSeeText('Budi Google')
            ->assertDontSeeText('Sari Google')
            ->assertDontSeeText('Budi Facebook');
    }
}
