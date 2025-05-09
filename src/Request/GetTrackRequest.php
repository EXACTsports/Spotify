<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;

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
        $response = SpotifyHttpClient::getApiCall($endpoint, $this->headers->toArray());
        
        if ($response instanceof BaseSpotifyResponse) {
            return $response;
        } elseif ($response instanceof ResponseInterface) {
            return new BaseSpotifyResponse($response->getData());
        } else {
            return new BaseSpotifyResponse([]);
        }
    }
}