<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class RewriteMediaUrls extends Command
{
    protected $signature = 'media:rewrite-urls {--from= : Prefix URL lama} {--to= : Prefix URL baru}';

    protected $description = 'Ganti prefix URL media di konten berita (mis. r2.dev → custom domain).';

    public function handle(): int
    {
        $from = (string) $this->option('from');
        $to = (string) $this->option('to');

        if ($from === '' || $to === '') {
            $this->error('Butuh --from dan --to.');

            return self::INVALID;
        }

        $updated = 0;
        News::query()
            ->where('content', 'like', "%{$from}%")
            ->eachById(function (News $news) use ($from, $to, &$updated): void {
                $news->forceFill(['content' => str_replace($from, $to, $news->content)])->saveQuietly();
                $updated++;
            });

        $this->info("Diperbarui: {$updated} berita.");

        return self::SUCCESS;
    }
}
