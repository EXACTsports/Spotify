<?php

namespace EXACTSports\Spotify\Tests;

use EXACTSports\Spotify\SpotifyServiceProvider;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers
     *
     * @param Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            SpotifyServiceProvider::class
        ];
    }
}