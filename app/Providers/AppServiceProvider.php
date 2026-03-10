<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire; 
use Illuminate\Support\Facades\Route;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env('APP_ENV') !== 'local') {
            $this->app->useStoragePath('/tmp/storage');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengubah URL script agar tidak berakhiran ".js"
        // Vercel tidak akan memblokirnya lagi dan akan meneruskannya ke Laravel
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/livewire/livewire-script', $handle); 
        });

        // Pastikan update route juga aman
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
