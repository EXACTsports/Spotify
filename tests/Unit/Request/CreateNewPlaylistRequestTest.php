<?php

namespace EXACTSports\Spotify\Tests\Unit\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\AddTrackToPlaylistRequest;
use EXACTSports\Spotify\Request\CreateNewPlaylistRequest;
use EXACTSports\Spotify\Request\Dto\NewPlaylistDto;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\Dto\TrackToPlaylistDto;
use EXACTSports\Spotify\Request\TopItemsRequest;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;

class CreateNewPlaylistRequestTest extends TestCase
{
    private ?CreateNewPlaylistRequest $request = null;

    protected function setUp(): void
    {
        parent::setUp();
        $dto = new NewPlaylistDto('spotifyId', 'name', 'description', true, false);
        $spotifyHeaders = new SpotifyHeaders('Bearer', 'testtoken');
        $this->request = new CreateNewPlaylistRequest($dto, $spotifyHeaders);
    }

    public function testRequestReturnExpectedResult(): void
    {
        $mockResponse = new BaseSpotifyResponse(['some' => 'data']);
        SpotifyHttpClient::shouldReceive('postApiCall')->once()->andReturn($mockResponse);
        $response = $this->request->execute();
        $this->assertSame(['some' => 'data'], $response->getData());
    }
}