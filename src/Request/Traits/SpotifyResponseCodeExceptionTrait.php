<?php

namespace EXACTSports\Spotify\Request\Traits;

use EXACTSports\Spotify\Exceptions\SpotifyBadResponseException;
use EXACTSports\Spotify\Exceptions\SpotifyTokenExpiredException;
use EXACTSports\Spotify\Exceptions\SpotifyUnauthorizedException;

trait SpotifyResponseCodeExceptionTrait
{
    /**
     * @throws SpotifyBadResponseException
     * @throws SpotifyUnauthorizedException
     * @throws SpotifyTokenExpiredException
     */
    public function handleException(\Exception $exception)
    {
        match ($exception->getCode()) {
            401 => throw new SpotifyTokenExpiredException($exception->getMessage()),
            403 => throw new SpotifyUnauthorizedException($exception->getMessage()),
            default => throw new SpotifyBadResponseException($exception->getMessage())
        };
    }
}