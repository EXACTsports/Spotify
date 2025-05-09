<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\NewPlaylistDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;

class CreateNewPlaylistRequest implements RequestInterface
{
    public function __construct(private NewPlaylistDto $newPlaylistDto, private SpotifyHeaders $headers)
    {

    }

    public function execute(): BaseSpotifyResponse
    {
        $response = SpotifyHttpClient::postApiCall(
            'v1/users/' . $this->newPlaylistDto->spotifyId . '/playlists',
            $this->headers->toArray(),
            $this->newPlaylistDto->toArray()
        );
        if ($response instanceof BaseSpotifyResponse) {
            return $response;
        } elseif ($response instanceof ResponseInterface) {
            return new BaseSpotifyResponse($response->getData());
        } else {
            return new BaseSpotifyResponse([]);
        }

    }
}