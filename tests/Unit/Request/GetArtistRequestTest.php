<?php

namespace EXACTSports\Spotify\Tests\Unit\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\AddTrackToPlaylistRequest;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\Dto\TrackToPlaylistDto;
use EXACTSports\Spotify\Request\GetArtistRequest;
use EXACTSports\Spotify\Request\TopItemsRequest;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;

class GetArtistRequestTest extends TestCase
{
    private ?GetArtistRequest $request = null;

    protected function setUp(): void
    {
        parent::setUp();
        $spotifyHeaders = new SpotifyHeaders('Bearer', 'testtoken');
        $this->request = new GetArtistRequest('artistId', $spotifyHeaders);
    }
    public function testRequestReturnExpectedResult(): void
    {
        $mockResponse = new BaseSpotifyResponse(['artist'=>'Rammstein']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $response = $this->request->execute();
        $this->assertSame(['artist'=>'Rammstein'], $response->getData());
    }
}