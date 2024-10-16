<?php
declare(strict_types=1);

namespace EXACTSports\Spotify;

use Illuminate\Support\ServiceProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->registerResources();
    }

    public function register(): void
    {

    }

    private function registerResources(): void
    {

        $this->registerFacades();
    }


    protected function registerFacades(): void
    {

        $this->app->singleton('SpotifyHttpClient', function ($app) {
            return new \EXACTSports\Spotify\HttpClientService();
        });
        $this->app->singleton('Spotify', function ($app) {
            return new \EXACTSports\Spotify\SpotifyService();
        });
    }
    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/spotify.php' =>config_path('spotify.php')
        ], 'spotify-config');
    }
}
