<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;

class GetTrackRequest implements RequestInterface
{
    public function __construct(
        private readonly string $id, private readonly SpotifyHeaders $headers
    )
    {
    }

    public function execute(): BaseSpotifyResponse
    {
        $endpoint = 'v1/tracks/' . $this->id;
        return SpotifyHttpClient::getApiCall($endpoint, $this->headers->toArray());
    }
}