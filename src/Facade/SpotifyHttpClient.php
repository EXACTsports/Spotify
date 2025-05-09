<?php

namespace EXACTSports\Spotify\Facade;

use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ResponseInterface getApiCall(string $endpoint, array $headers)
 * @method static ResponseInterface postApiCall(string $endpoint, array $headers, array $bodyParams = [])
 * @method static ResponseInterface postAccountCall(string $endpoint, array $headers, array $bodyParams = [])
 */
class SpotifyHttpClient extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'SpotifyHttpClient';
    }

}