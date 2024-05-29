<?php

namespace EXACTSports\Spotify\Client;

use EXACTSports\Spotify\Exceptions\SpotifyConnectionException;
use EXACTSports\Spotify\Exceptions\SpotifyTokenExpiredException;
use EXACTSports\Spotify\Models\SpotifyUserInterface;
use EXACTSports\Spotify\Request\Dto\SearchTrackRequestDto;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Request\RefreshTokenRequest;
use EXACTSports\Spotify\Request\SearchTrackRequest;
use EXACTSports\Spotify\Request\TopItemsRequest;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\TracksResponse;

class SpotifyClient
{

    /**
     * @throws SpotifyConnectionException
     */
    public function getUserTopItems(TopItemsRequestDto $requestDto): BaseSpotifyResponse
    {
        try {
            return (new TopItemsRequest($requestDto, $this->getHeaders($this->getUser())))->execute();
        } catch (SpotifyTokenExpiredException $exception) {
            return (new TopItemsRequest($requestDto, $this->getHeaders($this->getUser(), true)))->execute();
        }

    }

    public function searchTracks(SearchTrackRequestDto $requestDto): TracksResponse
    {
        try {
            $data = (new SearchTrackRequest($requestDto, $this->getHeaders($this->getUser())))->execute()->getData();
        } catch (SpotifyTokenExpiredException $exception) {
            $data = (new SearchTrackRequest($requestDto, $this->getHeaders($this->getUser(), true)))->execute()->getData();
        }
        return new TracksResponse(\Arr::get($data, 'tracks.items', []));
    }

    private function getUser(): SpotifyUserInterface
    {
        $user = \Auth::user();
        /**@var SpotifyUserInterface $user * */
        return $user;
    }


    /**
     * @throws SpotifyConnectionException
     */
    private function getHeaders(SpotifyUserInterface $user, bool $refreshToken = false): SpotifyHeaders
    {
        if ($user->getSpotifyId() && $user->getSpotifyAccessToken() && $refreshToken === false) {
            return new SpotifyHeaders('Bearer ' . $user->getSpotifyAccessToken());
        } elseif ($user->getSpotifyRefreshToken()) {
            $tokenResponse = (new RefreshTokenRequest($user))->execute();
            return new SpotifyHeaders('Bearer ' . $tokenResponse->getToken());
        }
        throw new SpotifyConnectionException("User doesn't have access token or refresh access token");
    }
}