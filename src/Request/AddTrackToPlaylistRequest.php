<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\TrackToPlaylistDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;

class AddTrackToPlaylistRequest implements RequestInterface
{
    public function __construct(private TrackToPlaylistDto $trackToPlaylistDto, private SpotifyHeaders $headers)
    {

    }

    public function execute(): BaseSpotifyResponse
    {
        $response = SpotifyHttpClient::postApiCall(
           'v1/playlists/'.$this->trackToPlaylistDto->playlistId.'/tracks',
            $this->headers->toArray(),
            $this->trackToPlaylistDto->toArray()
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