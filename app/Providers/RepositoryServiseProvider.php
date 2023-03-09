<?php

namespace App\Providers;

use App\Interfaces\Repositories\SMSRepository as SMSRepositoryInterface;
use App\Interfaces\Repositories\ShiftRepository as ShiftRepositoryInterface;
use App\Repositories\ShiftRepository;
use App\Repositories\SMSRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiseProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        $this->app->bind(SMSRepositoryInterface::class, SMSRepository::class);
        $this->app->bind(ShiftRepositoryInterface::class, ShiftRepository::class);

    }
}
