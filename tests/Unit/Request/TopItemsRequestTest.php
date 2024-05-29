<?php

namespace EXACTSports\Spotify\Tests\Unit\Request;

use EXACTSports\Spotify\Client\SpotifyHeaders;
use EXACTSports\Spotify\Facade\SpotifyHttpClient;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\TopItemsRequest;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Tests\TestCase;

class TopItemsRequestTest extends TestCase
{
    private ?TopItemsRequest $topItemsRequest = null;

    protected function setUp(): void
    {
        parent::setUp();
        $topItemsRequestDto = new TopItemsRequestDto();
        $topItemsRequestDto->limit = 10;
        $topItemsRequestDto->offset = 0;
        $topItemsRequestDto->timeRange = 'medium_term';
        $spotifyHeaders = new SpotifyHeaders('Bearer', 'testtoken');
        $this->topItemsRequest = new TopItemsRequest($topItemsRequestDto, $spotifyHeaders);
    }
    public function testCanExecuteRequest()
    {
        $mockResponse = new BaseSpotifyResponse(['some'=>'data']);
        SpotifyHttpClient::shouldReceive('getApiCall')->once()->andReturn($mockResponse);
        $response = $this->topItemsRequest->execute();
        $this->assertSame(['some'=>'data'], $response->getData());
    }
}