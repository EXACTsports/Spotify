<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;

class TopItemsRequest implements RequestInterface
{
    public function __construct(
        private readonly TopItemsRequestDto $requestDto, private readonly SpotifyHeaders $headers
    )
    {
    }

    public function execute(): BaseSpotifyResponse
    {
        $endpoint = 'v1/me/top/tracks?limit=' . $this->requestDto->limit .
            '&offset=' . $this->requestDto->offset .
            '&time_range=' . $this->requestDto->timeRange;
        return SpotifyHttpClient::getApiCall($endpoint, $this->headers->toArray());
    }
}