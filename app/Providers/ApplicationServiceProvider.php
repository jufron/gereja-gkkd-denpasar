<?php

namespace App\Providers;

use App\Contracts\Services\HomeContentServiceInterface;
use App\Contracts\Services\NewsServiceInterface;
use App\Services\HomeContentService;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Pemetaan kontrak ke implementasi service aplikasi.
     *
     * @var array<class-string, class-string>
     */
    public array $singletons = [
        HomeContentServiceInterface::class => HomeContentService::class,
        NewsServiceInterface::class => NewsService::class,
    ];
}
