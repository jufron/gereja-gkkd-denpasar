<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HomeContentServiceInterface;
use App\Contracts\Services\NewsServiceInterface;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct(
        private readonly HomeContentServiceInterface $homeContentService,
        private readonly NewsServiceInterface $newsService,
    ) {}

    public function index()
    {
        return view('home', $this->homeContentService->getHomeData());
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function berita(Request $request)
    {
        $kategori = $request->query('kategori');

        return view('berita', $this->newsService->getBeritaData(
            kategori: is_string($kategori) ? $kategori : null,
            search: trim((string) $request->query('q', '')),
            queryParams: $request->query(),
        ));
    }

    public function galeri()
    {
        return view('galeri');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function kegiatanIndex()
    {
        return view('kegiatan.index');
    }

    public function pelayanan()
    {
        return view('kegiatan.pelayanan');
    }

    public function komsel()
    {
        return view('kegiatan.komsel');
    }

    public function retretCamp()
    {
        return view('kegiatan.retret-camp');
    }

    public function khotbahShow(string $slug)
    {
        return view('kegiatan.khotbah-detail', ['slug' => $slug]);
    }
}
