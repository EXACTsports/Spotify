<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Exceptions\SpotifyConnectionException;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Contracts\SpotifyUserInterface;
use EXACTSports\Spotify\Response\RefreshTokenResponse;

final readonly class RefreshTokenRequest implements RequestInterface
{

    public function __construct(private SpotifyUserInterface $user)
    {

    }

    /**
     * @throws SpotifyConnectionException
     */
    public function execute(): RefreshTokenResponse
    {

        $headers = new SpotifyHeaders(
            'Basic ' . base64_encode(config('spotify.client_id') . ':' . config('spotify.client_secret')),
            'application/x-www-form-urlencoded');
        $formParams = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->user->getSpotifyRefreshToken(),
        ];

        try {
            $response = SpotifyHttpClient::postAccountCall('api/token', $headers->toArray(), $formParams);
            $newAccessToken = $response->getData()['access_token'] ?? null;
            $this->user->renewSpotifyToken($newAccessToken);
            return new RefreshTokenResponse($newAccessToken);
        } catch (\Throwable $throwable) {
            throw new SpotifyConnectionException("We can't refresh token" . $this->user->getSpotifyRefreshToken() . ". Because of error - " . $throwable->getMessage());
        }

    }
}