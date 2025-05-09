<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\SearchTrackRequestDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;

class SearchTrackRequest implements RequestInterface
{
    public function __construct(
        private readonly SearchTrackRequestDto $requestDto, private readonly SpotifyHeaders $headers
    )
    {
    }

    public function execute(): BaseSpotifyResponse
    {
        $endpoint = 'v1/search?query=' . $this->requestDto->search .
            '&type=track&limit=' . $this->requestDto->limit .
            '&include_external=' . $this->requestDto->includeExternal;
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