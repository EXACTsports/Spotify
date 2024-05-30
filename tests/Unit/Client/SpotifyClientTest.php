<?php

namespace EXACTSports\Spotify\Tests\Unit\Client;

use EXACTSports\Spotify\Client\SpotifyClient;
use EXACTSports\Spotify\Exceptions\SpotifyTokenExpiredException;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Models\SpotifyUserInterface;
use EXACTSports\Spotify\Request\Dto\NewPlaylistDto;
use EXACTSports\Spotify\Request\Dto\SearchTrackRequestDto;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\Dto\TrackToPlaylistDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;
use Mockery\MockInterface;

class SpotifyClientTest extends TestCase
{
    public function testReceiveUserTopTracks(): void
    {
        $this->mockBaseData();
        $request = new TopItemsRequestDto();
        $mockResponse = new BaseSpotifyResponse(['some' => 'data']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getUserTopItems($request);
        $this->assertSame(['some' => 'data'], $result->getData());
    }
    public function testSearchTracks(): void
    {
        $this->mockBaseData();
        $request = new SearchTrackRequestDto("some track");
        $mockResponse = new BaseSpotifyResponse(['tracks' => ['items' => [['item' => 1]]]]);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->searchTracks($request);
        $this->assertSame([['item' => 1]], $result->getTracks());
    }
    public function testGetTrack(): void
    {
        $this->mockBaseData();
        $mockResponse = new BaseSpotifyResponse(['track' => "some info"]);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getTrack('someTrackId');
        $this->assertSame(['track' => "some info"], $result->getData());
    }
    public function testGetArtist(): void
    {
        $this->mockBaseData();
        $mockResponse = new BaseSpotifyResponse(['artist' => "some info"]);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getArtist('artistId');
        $this->assertSame(['artist' => "some info"], $result->getData());
    }
    public function testCreateNewPlaylist(): void
    {
        $this->mockBaseData();
        $mockResponse = new BaseSpotifyResponse(['playlistCreated' => true]);
        SpotifyHttpClient::shouldReceive('postApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->addNewPlaylist(new NewPlaylistDto('spotifyId'));
        $this->assertSame(['playlistCreated' => true], $result->getData());
    }
    public function testAddTrackToPlaylist(): void
    {
        $this->mockBaseData();
        $mockResponse = new BaseSpotifyResponse(['trackAdded' => true]);
        SpotifyHttpClient::shouldReceive('postApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->addTrackToPlaylist(new TrackToPlaylistDto('playlistId', ['someUrl']));
        $this->assertSame(['trackAdded' => true], $result->getData());
    }

    public function testReceiveUserTopTracksWithUnauthorizedException(): void
    {
        $userMock = $this->mockBaseData();
        $userMock->shouldReceive('getSpotifyRefreshToken')->andReturn("refreshToken");
        $userMock->shouldReceive('renewSpotifyToken')->with('newToken');
        $request = new TopItemsRequestDto();
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andThrow(new SpotifyTokenExpiredException());
        SpotifyHttpClient::shouldReceive('postAccountCall')->once()->andReturn(new BaseSpotifyResponse(['access_token' => 'newToken']));
        $mockResponse = new BaseSpotifyResponse(['some' => 'data']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getUserTopItems($request);
        $this->assertSame(['some' => 'data'], $result->getData());
    }

    private function mockBaseData(): MockInterface
    {
        $userMock = $this->mock(SpotifyUserInterface::class);
        \Auth::shouldReceive('user')->andReturn($userMock);
        $userMock->shouldReceive('getSpotifyId')->andReturn("spotifyId");
        $userMock->shouldReceive('getSpotifyAccessToken')->andReturn("accessToken");
        return $userMock;
    }
}