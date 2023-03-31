<?php

namespace App\Providers;

use App\Services\KingSoldSearchService;
use App\Services\UserMoneyService;
use App\Services\UserWorkTimeService;
use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(KingSoldSearchService::class, KingSoldSearchService::class);
        $this->app->bind(UserMoneyService::class, UserMoneyService::class);
        $this->app->bind(UserWorkTimeService::class, UserWorkTimeService::class);
    }
}
