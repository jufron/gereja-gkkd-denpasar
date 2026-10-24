<?php

namespace App\Console\Commands;

use App\Models\AssetLibrary;
use App\Models\AssetUsage;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PruneOrphanMedia extends Command
{
    protected $signature = 'media:prune {--days=7 : Umur minimal (hari) media tanpa pemakaian}';

    protected $description = 'Hapus file media yang tidak dipakai berita mana pun dan berumur di atas batas.';

    public function handle(): int
    {
        $cutoff = now()->subDays((int) $this->option('days'));

        $orphans = Media::query()
            ->where('model_type', AssetLibrary::class)
            ->where('created_at', '<', $cutoff)
            ->whereNotIn('id', AssetUsage::select('media_id'))
            ->get();

        $count = 0;
        foreach ($orphans as $media) {
            $media->delete();
            $count++;
        }

        $this->info("Prune selesai: {$count} media yatim dihapus.");

        return self::SUCCESS;
    }
}
