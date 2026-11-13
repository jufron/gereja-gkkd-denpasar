<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSermonEvaluationRequest;
use App\Models\SermonEvaluation;

class SermonEvaluationController extends Controller
{
    public function create()
    {
        $tahunIni = (int) now()->year;

        return view('evaluasi-khotbah', [
            'bulan' => SermonEvaluation::BULAN,
            'rating' => SermonEvaluation::RATING,
            'tahunOptions' => [$tahunIni - 1, $tahunIni, $tahunIni + 1],
            'bulanIni' => (int) now()->month,
            'tahunIni' => $tahunIni,
        ]);
    }

    public function store(StoreSermonEvaluationRequest $request)
    {
        if ($request->isBot()) {
            return redirect()->route('evaluasi-khotbah')
                ->with('success', 'Terima kasih atas evaluasi Anda.');
        }

        SermonEvaluation::create($request->prepared());

        return redirect()->route('evaluasi-khotbah')
            ->with('success', 'Terima kasih! Evaluasi Anda membantu kami membentuk mimbar yang lebih membangun.');
    }
}
