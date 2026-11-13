<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SermonEvaluation;

/**
 * Pengelolaan evaluasi khotbah bulanan di dashboard. Khusus Administrator.
 */
final class SermonEvaluationController extends Controller
{
    public function index()
    {
        return view('dashboard.evaluasi-khotbah');
    }

    public function show(SermonEvaluation $evaluation)
    {
        return view('dashboard.evaluasi-khotbah-detail', [
            'evaluasi' => $evaluation,
        ]);
    }

    public function destroy(SermonEvaluation $evaluation)
    {
        $evaluation->delete();

        activity('evaluasi')
            ->withProperties(['bulan' => $evaluation->bulan, 'tahun' => $evaluation->tahun])
            ->log('Hapus evaluasi khotbah');

        return redirect()->route('admin.evaluasi-khotbah.index')
            ->with('success', 'Evaluasi dihapus permanen.');
    }
}
