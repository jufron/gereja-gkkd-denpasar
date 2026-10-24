<?php

namespace Tests\Feature;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ProfileSecurityTest extends TestCase
{
    use RefreshDatabase;

    private const CURRENT_SESSION = 'sesi-saat-ini';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    private function withSessionCookie(): static
    {
        return $this->withCookie(session()->getName(), self::CURRENT_SESSION);
    }

    private function insertSession(string $id, ?int $lastActivity = null): void
    {
        DB::table('sessions')->insert([
            'id' => $id,
            'user_id' => $this->user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'payload' => '',
            'last_activity' => $lastActivity ?? time(),
        ]);
    }

    private function token(string $sessionId): string
    {
        return hash_hmac('sha256', $sessionId, config('app.key'));
    }

    public function test_halaman_sekuriti_menampilkan_perangkat_terhubung(): void
    {
        $this->insertSession(self::CURRENT_SESSION);
        $this->insertSession('sesi-lain', strtotime('-2 hours'));

        $this->withSessionCookie()
            ->get(route('dashboard.profile.security'))
            ->assertOk()
            ->assertSee('Chrome')
            ->assertSee('Saat Ini')
            ->assertSee('Jaringan Lokal');
    }

    public function test_akhiri_sesi_perangkat_lain(): void
    {
        $this->insertSession(self::CURRENT_SESSION);
        $this->insertSession('sesi-lain');

        $this->withSessionCookie()
            ->delete(route('dashboard.profile.session.destroy', $this->token('sesi-lain')))
            ->assertRedirect();

        $this->assertDatabaseMissing('sessions', ['id' => 'sesi-lain']);
        $this->assertDatabaseHas('sessions', ['id' => self::CURRENT_SESSION]);
    }

    public function test_tidak_bisa_akhiri_sesi_sendiri(): void
    {
        $this->insertSession(self::CURRENT_SESSION);

        $session = $this->createMock(\Illuminate\Contracts\Session\Session::class);
        $session->method('getId')->willReturn(self::CURRENT_SESSION);

        $request = Request::create(
            route('dashboard.profile.session.destroy', $this->token(self::CURRENT_SESSION)),
            'DELETE',
        );
        $request->setLaravelSession($session);
        $request->setUserResolver(fn () => $this->user);

        $this->expectException(NotFoundHttpException::class);

        (new ProfileController)->destroySession($request, $this->token(self::CURRENT_SESSION));

        $this->assertDatabaseHas('sessions', ['id' => self::CURRENT_SESSION]);
    }

    public function test_tidak_bisa_akhiri_sesi_user_lain(): void
    {
        $other = User::factory()->create();
        $this->insertSession('sesi-lain');
        DB::table('sessions')->where('id', 'sesi-lain')->update(['user_id' => $other->id]);

        $this->withSessionCookie()
            ->delete(route('dashboard.profile.session.destroy', $this->token('sesi-lain')))
            ->assertNotFound();

        $this->assertDatabaseHas('sessions', ['id' => 'sesi-lain', 'user_id' => $other->id]);
    }

    public function test_token_palsu_ditolak(): void
    {
        $this->insertSession('sesi-lain');

        $this->withSessionCookie()
            ->delete(route('dashboard.profile.session.destroy', str_repeat('0', 64)))
            ->assertNotFound();
    }
}
