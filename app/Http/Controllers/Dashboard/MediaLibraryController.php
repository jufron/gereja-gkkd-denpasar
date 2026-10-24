<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssetUsage;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Pustaka media: menjelajah & memilih aset yang sudah diupload untuk
 * dipakai ulang di artikel. File hanya bisa dihapus jika tidak dipakai
 * berita mana pun.
 */
final class MediaLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query()
            ->whereIn('collection_name', ['news-content', 'news-banner'])
            ->where('mime_type', 'like', 'image/%');

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('file_name', 'like', "%{$q}%");
            });
        }

        $media = $query->latest('id')->paginate(24);

        return response()->json([
            'media' => $media->through(fn (Media $m) => [
                'id' => $m->id,
                'name' => $m->name,
                'url' => $m->getUrl(),
                'thumb' => $m->getUrl('thumb'),
                'created_at' => optional($m->created_at)->diffForHumans(),
            ]),
            'current_page' => $media->currentPage(),
            'last_page' => $media->lastPage(),
            'total' => $media->total(),
        ]);
    }

    /**
     * Hapus media hanya jika tidak dipakai berita mana pun.
     */
    public function destroy(Media $media)
    {
        abort_if(AssetUsage::where('media_id', $media->id)->exists(), 422, 'Aset sedang dipakai berita.');

        $media->delete();

        return response()->json(['ok' => true]);
    }
}
