<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SaveSermonRequest;
use App\Models\AssetLibrary;
use App\Models\AssetUsage;
use App\Models\Sermon;
use Mews\Purifier\Facades\Purifier;

/**
 * Pengelolaan rangkuman khotbah di dashboard. Khusus Administrator
 * dengan permission "Kelola Khotbah".
 *
 * Controller memang orkestrasi alur (validasi, sanitasi HTML, upload media,
 * slug) secara langsung — logika cukup kecil, tanpa service terpisah.
 */
final class KhotbahController extends Controller
{
    public function index()
    {
        return view('dashboard.khotbah');
    }

    public function create()
    {
        return view('dashboard.khotbah-form', [
            'sermon' => new Sermon,
            'isEdit' => false,
        ]);
    }

    public function edit(Sermon $sermon)
    {
        return view('dashboard.khotbah-form', [
            'sermon' => $sermon,
            'isEdit' => true,
        ]);
    }

    public function store(SaveSermonRequest $request)
    {
        $this->persist(new Sermon, $request->safe()->all());

        return redirect()->route('admin.khotbah.index')
            ->with('success', 'Khotbah ditambahkan.');
    }

    public function update(SaveSermonRequest $request, Sermon $sermon)
    {
        $this->persist($sermon, $request->safe()->all());

        return redirect()->route('admin.khotbah.index')
            ->with('success', 'Khotbah diperbarui.');
    }

    public function destroy(Sermon $sermon)
    {
        $sermon->delete();

        return back()->with('success', 'Khotbah dihapus.');
    }

    private function persist(Sermon $sermon, array $data): void
    {
        $contentClean = Purifier::clean($data['content']);

        $sermon->fill([
            'title' => $data['title'],
            'slug' => Sermon::uniqueSlug($data['title'], $sermon->exists ? $sermon->id : null),
            'preacher' => $data['preacher'],
            'preached_at' => $data['preached_at'],
            'location' => $data['location'] ?? null,
            'content' => $contentClean,
            'ppt_url' => $data['ppt_url'] ?? null,
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published'
                ? ($data['published_at'] ?? ($sermon->published_at ?? now()))
                : ($sermon->published_at ?? null),
        ])->save();

        $this->setImage($sermon, 'thumbnail', 'sermon-thumbnail', $data['thumbnail'] ?? null, $data['hapus_thumbnail'] ?? false);
    }

    /**
     * Atur media (thumbnail / foto pengkhotbah). Upload baru → media baru +
     * usage; hapus → lepas usage (file lama jadi yatim, dibersihkan prune).
     */
    private function setImage(Sermon $sermon, string $kind, string $collection, mixed $file, bool $hapus): void
    {
        if ($file === null && ! $hapus) {
            return;
        }

        AssetUsage::where('sermon_id', $sermon->id)->where('kind', $kind)->delete();

        if ($file === null) {
            return;
        }

        $library = AssetLibrary::singleton();
        $media = $library->addMedia($file)->toMediaCollection($collection);

        AssetUsage::create([
            'sermon_id' => $sermon->id,
            'media_id' => $media->id,
            'kind' => $kind,
        ]);
    }
}
