<?php

namespace EXACTSports\Spotify\Tests\Unit\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\AddTrackToPlaylistRequest;
use EXACTSports\Spotify\Request\Dto\SearchTrackRequestDto;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\Dto\TrackToPlaylistDto;
use EXACTSports\Spotify\Request\GetArtistRequest;
use EXACTSports\Spotify\Request\GetTrackRequest;
use EXACTSports\Spotify\Request\SearchTrackRequest;
use EXACTSports\Spotify\Request\TopItemsRequest;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;

class SearchRequestTrackRequestTest extends TestCase
{
    private ?SearchTrackRequest $request = null;

    protected function setUp(): void
    {
        parent::setUp();
        $dto = new SearchTrackRequestDto('sometrack');
        $spotifyHeaders = new SpotifyHeaders('Bearer', 'testtoken');
        $this->request = new SearchTrackRequest($dto, $spotifyHeaders);
    }

    public function testRequestReturnExpectedResult(): void
    {
        $mockResponse = new BaseSpotifyResponse(['tracks' => ['items' => [['item' => 1]]]]);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $response = $this->request->execute();
        $this->assertSame(['tracks' => ['items' => [['item' => 1]]]], $response->getData());
    }
}