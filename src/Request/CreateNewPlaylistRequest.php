<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\NewPlaylistDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;

class CreateNewPlaylistRequest implements RequestInterface
{
    public function __construct(private NewPlaylistDto $newPlaylistDto, private SpotifyHeaders $headers)
    {

    }

    public function execute(): BaseSpotifyResponse
    {
        return SpotifyHttpClient::postApiCall(
            'v1/users/' . $this->newPlaylistDto->spotifyId . '/playlists',
            $this->headers->toArray(),
            $this->newPlaylistDto->toArray()
        );

    }
}