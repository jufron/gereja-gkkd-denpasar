<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\Request;

/**
 * Pengelolaan permohonan doa di dashboard. Khusus Administrator.
 */
final class PrayerRequestController extends Controller
{
    public function index()
    {
        return view('dashboard.doa');
    }

    public function show(PrayerRequest $prayerRequest)
    {
        return view('dashboard.doa-detail', [
            'doa' => $prayerRequest,
            'status' => PrayerRequest::STATUS,
            'kategori' => PrayerRequest::KATEGORI,
        ]);
    }

    public function updateStatus(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai'],
        ]);

        $prayerRequest->update([
            'status' => $validated['status'],
            'didoakan_pada' => $validated['status'] === 'selesai'
                ? ($prayerRequest->didoakan_pada ?? now())
                : $prayerRequest->didoakan_pada,
        ]);

        return back()->with('success', 'Status permohonan doa diperbarui.');
    }

    public function updateCatatan(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'catatan_internal' => ['nullable', 'string', 'max:2000'],
        ]);

        $prayerRequest->update([
            'catatan_internal' => $validated['catatan_internal'] ?? null,
        ]);

        activity('doa')
            ->on($prayerRequest)
            ->log('Ubah catatan internal doa');

        return back()->with('success', 'Catatan internal disimpan.');
    }

    public function destroy(PrayerRequest $prayerRequest)
    {
        $prayerRequest->delete();

        return back()->with('success', 'Permohonan doa dipindahkan ke keranjang sampah.');
    }

    public function restore(int $id)
    {
        $prayerRequest = PrayerRequest::onlyTrashed()->findOrFail($id);
        $prayerRequest->restore();

        return redirect()->route('admin.doa.index')->with('success', 'Permohonan doa dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        $prayerRequest = PrayerRequest::onlyTrashed()->findOrFail($id);
        $prayerRequest->forceDelete();

        activity('doa')
            ->withProperties(['id' => $prayerRequest->id])
            ->log('Doa dihapus permanen');

        return redirect()->route('admin.doa.index')->with('success', 'Permohonan doa dihapus permanen.');
    }
}
