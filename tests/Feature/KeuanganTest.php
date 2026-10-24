<?php

namespace Tests\Feature;

use App\Contracts\Services\FinanceServiceInterface;
use App\Models\FinanceCategory;
use App\Models\FinanceTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KeuanganTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('Administrator');
        $this->actingAs($this->admin);
    }

    private function service(): FinanceServiceInterface
    {
        return app(FinanceServiceInterface::class);
    }

    private function incomeCategory(): FinanceCategory
    {
        return FinanceCategory::where('type', 'income')->first();
    }

    private function expenseCategory(): FinanceCategory
    {
        return FinanceCategory::where('type', 'expense')->first();
    }

    public function test_halaman_keuangan_terbuka_untuk_admin(): void
    {
        $this->get(route('admin.keuangan.masuk'))->assertOk();
        $this->get(route('admin.keuangan.keluar'))->assertOk();
        $this->get(route('admin.keuangan.kategori'))->assertOk();
    }

    public function test_simpan_pemasukan_mencatat_transaksi(): void
    {
        $cat = $this->incomeCategory();

        Livewire::test('dashboard.kas-table', ['tipe' => 'income'])
            ->set('financeCategoryId', $cat->id)
            ->set('transactionDate', '2026-10-20')
            ->set('amount', '1.500.000')
            ->set('description', 'Persembahan Mingguan Oktober')
            ->set('referenceNo', 'KW-001')
            ->call('simpan');

        $this->assertDatabaseHas('finance_transactions', [
            'finance_category_id' => $cat->id,
            'amount' => 1500000,
            'description' => 'Persembahan Mingguan Oktober',
            'status' => 'posted',
        ]);
    }

    public function test_tipe_kategori_terkunci_sesuai_halaman(): void
    {
        $expenseCat = $this->expenseCategory();

        // Coba simpan kategori pengeluaran di halaman Kas Masuk → ditolak.
        Livewire::test('dashboard.kas-table', ['tipe' => 'income'])
            ->set('financeCategoryId', $expenseCat->id)
            ->set('transactionDate', '2026-10-20')
            ->set('amount', '50000')
            ->set('description', 'Percobaan salah kategori')
            ->call('simpan')
            ->assertStatus(422);

        $this->assertDatabaseMissing('finance_transactions', [
            'finance_category_id' => $expenseCat->id,
            'description' => 'Percobaan salah kategori',
        ]);
    }

    public function test_ringkasan_menghitung_masuk_keluar_saldo(): void
    {
        $incomeCat = $this->incomeCategory();
        $expenseCat = $this->expenseCategory();

        $sebelum = $this->service()->ringkasan();

        $this->service()->create([
            'finance_category_id' => $incomeCat->id,
            'transaction_date' => now()->toDateString(),
            'amount' => 100000,
            'description' => 'Masuk 1',
        ]);
        $this->service()->create([
            'finance_category_id' => $incomeCat->id,
            'transaction_date' => now()->toDateString(),
            'amount' => 50000,
            'description' => 'Masuk 2',
        ]);
        $this->service()->create([
            'finance_category_id' => $expenseCat->id,
            'transaction_date' => now()->toDateString(),
            'amount' => 30000,
            'description' => 'Keluar 1',
        ]);

        $sesudah = $this->service()->ringkasan();

        // Delta dari data seeder — bukan absolut.
        $this->assertSame(150000, $sesudah['masuk'] - $sebelum['masuk']);
        $this->assertSame(30000, $sesudah['keluar'] - $sebelum['keluar']);
        $this->assertSame(120000, $sesudah['saldo'] - $sebelum['saldo']);
    }

    public function test_void_mengeluarkan_transaksi_dari_laporan_tapi_tetap_tersimpan(): void
    {
        $cat = $this->incomeCategory();
        $baseline = $this->service()->total('income');

        $tx = $this->service()->create([
            'finance_category_id' => $cat->id,
            'transaction_date' => now()->toDateString(),
            'amount' => 100000,
            'description' => 'Persembahan',
        ]);

        $this->assertSame($baseline + 100000, $this->service()->total('income'));

        $this->service()->void($tx, 'Salah nominal.');

        $this->assertDatabaseHas('finance_transactions', [
            'id' => $tx->id,
            'status' => 'void',
            'void_reason' => 'Salah nominal.',
        ]);

        $this->assertSame($baseline, $this->service()->total('income'));
    }

    public function test_kategori_yang_dipakai_tidak_bisa_dihapus(): void
    {
        $cat = $this->incomeCategory();
        $this->service()->create([
            'finance_category_id' => $cat->id,
            'transaction_date' => '2026-10-10',
            'amount' => 100000,
            'description' => 'Persembahan',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $cat->delete();
    }

    public function test_non_admin_tidak_bisa_akses_keuangan(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('admin.keuangan.masuk'))->assertForbidden();
        $this->get(route('admin.keuangan.kategori'))->assertForbidden();
    }
}
