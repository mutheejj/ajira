<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Force HTTPS on production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Ensure storage symlink exists
        $this->ensureStorageLinkExists();
    }
    
    /**
     * Ensure storage symlink exists or create it
     */
    protected function ensureStorageLinkExists(): void
    {
        // Get the public path to the storage directory
        $publicPath = public_path('storage');
        $storagePath = storage_path('app/public');
        
        // If the public storage directory doesn't exist, create the symlink
        if (!file_exists($publicPath) && file_exists($storagePath)) {
            try {
                // On Windows, we'll use different method to create symlink
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    exec('mklink /D "' . $publicPath . '" "' . $storagePath . '"');
                } else {
                    symlink($storagePath, $publicPath);
                }
                
                if (file_exists($publicPath)) {
                    \Log::info('Storage symlink created successfully');
                } else {
                    \Log::warning('Failed to create storage symlink');
                }
            } catch (\Exception $e) {
                \Log::error('Error creating storage symlink: ' . $e->getMessage());
            }
        }
    }
}
