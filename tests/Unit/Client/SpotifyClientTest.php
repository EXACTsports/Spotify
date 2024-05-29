<?php

namespace EXACTSports\Spotify\Tests\Unit\Client;

use EXACTSports\Spotify\Client\SpotifyClient;
use EXACTSports\Spotify\Exceptions\SpotifyTokenExpiredException;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Models\SpotifyUserInterface;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;
class SpotifyClientTest extends TestCase
{
    public function testReceiveUserTopTracks(): void
    {
        $userMock = $this->mock(SpotifyUserInterface::class);
        \Auth::shouldReceive('user')->andReturn($userMock);
        $userMock->shouldReceive('getSpotifyId')->andReturn("spotifyId");
        $userMock->shouldReceive('getSpotifyAccessToken')->andReturn("accessToken");
        $request= new TopItemsRequestDto();
        $mockResponse = new BaseSpotifyResponse(['some'=>'data']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getUserTopItems($request);
        $this->assertSame(['some'=>'data'], $result->getData());
    }
    public function testReceiveUserTopTracksWithUnauthorizedException(): void
    {
        $userMock = $this->mock(SpotifyUserInterface::class);
        \Auth::shouldReceive('user')->andReturn($userMock);
        $userMock->shouldReceive('getSpotifyId')->andReturn("spotifyId");
        $userMock->shouldReceive('getSpotifyAccessToken')->andReturn("accessToken");
        $userMock->shouldReceive('getSpotifyRefreshToken')->andReturn("refreshToken");
        $userMock->shouldReceive('renewSpotifyToken')->with('newToken');
        $request= new TopItemsRequestDto();
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andThrow(new SpotifyTokenExpiredException());
        SpotifyHttpClient::shouldReceive('postAccountCall')->once()->andReturn(new BaseSpotifyResponse(['access_token'=>'newToken']));
        $mockResponse = new BaseSpotifyResponse(['some'=>'data']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $client = new SpotifyClient();
        $result = $client->getUserTopItems($request);
        $this->assertSame(['some'=>'data'], $result->getData());
    }
}