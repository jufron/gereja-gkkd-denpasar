<?php

namespace App\Providers;

use App\Contracts\Services\FinanceServiceInterface;
use App\Contracts\Services\HomeContentServiceInterface;
use App\Contracts\Services\NewsManagementServiceInterface;
use App\Contracts\Services\NewsServiceInterface;
use App\Services\FinanceService;
use App\Services\HomeContentService;
use App\Services\NewsManagementService;
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
        FinanceServiceInterface::class => FinanceService::class,
        HomeContentServiceInterface::class => HomeContentService::class,
        NewsServiceInterface::class => NewsService::class,
        NewsManagementServiceInterface::class => NewsManagementService::class,
    ];
}
