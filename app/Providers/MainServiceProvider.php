<?php

namespace App\Providers;

use App\Services\KingSoldSearchService;
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
    }
}
