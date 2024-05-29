<?php

namespace EXACTSports\Spotify\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getApiCall(string $endpoint, array $headers)
 * @method static postAccountCall(string $endpoint, array $headers, array $bodyParams)
 */
class SpotifyHttpClient extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'SpotifyHttpClient';
    }

}