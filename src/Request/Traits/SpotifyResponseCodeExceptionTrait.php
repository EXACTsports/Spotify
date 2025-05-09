<?php

namespace EXACTSports\Spotify\Request\Traits;

use EXACTSports\Spotify\Exceptions\SpotifyBadResponseException;
use EXACTSports\Spotify\Exceptions\SpotifyTokenExpiredException;
use EXACTSports\Spotify\Exceptions\SpotifyUnauthorizedException;
use GuzzleHttp\Exception\RequestException;

trait SpotifyResponseCodeExceptionTrait
{
    /**
     * @throws SpotifyBadResponseException
     * @throws SpotifyUnauthorizedException
     * @throws SpotifyTokenExpiredException
     */
    public function handleException(\Exception $exception)
    {
        $statusCode = null;
        if ($exception instanceof RequestException && $exception->hasResponse()) {
            $statusCode = $exception->getResponse()->getStatusCode();
        } else {
            // Fallback for non-Guzzle exceptions or Guzzle exceptions without a response
            // or if getCode() is more appropriate for other exception types.
            $statusCode = $exception->getCode();
        }

        $message = $exception->getMessage();

        match ($statusCode) {
            401 => throw new SpotifyTokenExpiredException($message, $statusCode, $exception),
            403 => throw new SpotifyUnauthorizedException($message, $statusCode, $exception),
            // It's good practice to include the status code in the default message if it's an HTTP error
            default => throw new SpotifyBadResponseException(
                "Spotify API request failed with status code: {$statusCode}. Message: {$message}",
                is_int($statusCode) ? $statusCode : 0, // Ensure code is an int for the exception constructor
                $exception
            )
        };
    }
}