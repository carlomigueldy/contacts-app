<?php

namespace App\Providers;

use App\Repository\ContactRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\ContactRepository;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
