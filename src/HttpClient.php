<?php

namespace EXACTSports\Spotify;

use EXACTSports\Spotify\Request\Traits\SpotifyResponseCodeExceptionTrait;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\ResponseInterface;
use Exception;
use GuzzleHttp\Client;

class HttpClient
{
    private string $baseApiUrl = 'https://api.spotify.com';
    private string $baseAccountUrl = 'https://accounts.spotify.com';
    use SpotifyResponseCodeExceptionTrait;

    public function getApiCall(string $endpoint, array $headers): ResponseInterface
    {
        try {
            $client = new Client(['base_uri' => $this->baseApiUrl]);
            $response = $client->get($endpoint, ['headers' => $headers]);
            $stream = $response->getBody();
            $size = $stream->getSize();
            $content = json_decode($stream->read($size), true, 512, JSON_THROW_ON_ERROR);
            return new BaseSpotifyResponse($content);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * @throws \Throwable
     */
    public function postAccountCall(string $endpoint, array $headers, array $bodyParams = []): ResponseInterface
    {
        $client = new Client(['base_uri' => $this->baseAccountUrl]);
        $response = $client->post($endpoint, [
            'headers' => $headers,
            'form_params' => $bodyParams,
        ]);
        $stream = $response->getBody();
        $size = $stream->getSize();
        $response = json_decode($stream->read($size), true, 512, JSON_THROW_ON_ERROR);
        return new BaseSpotifyResponse($response);
    }
}