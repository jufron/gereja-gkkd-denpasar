<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrayerRequestRequest;
use App\Models\PrayerRequest;

class PrayerRequestController extends Controller
{
    public function create()
    {
        return view('doa', [
            'kategori' => PrayerRequest::KATEGORI,
        ]);
    }

    public function store(StorePrayerRequestRequest $request)
    {
        if ($request->isBot()) {
            // Bot: tolak diam-diam, tanpa buat record.
            return redirect()->route('doa')->with('success', 'Permohonan doa Anda telah dikirim.');
        }

        PrayerRequest::create($request->prepared());

        return redirect()->route('doa')->with('success', 'Permohonan doa Anda telah dikirim. Tim doa kami akan mendoakan.');
    }
}
