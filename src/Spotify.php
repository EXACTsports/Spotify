<?php

namespace EXACTSports\Spotify;

use EXACTSports\Spotify\Client\SpotifyClient;
use EXACTSports\Spotify\Exceptions\MissingSpotifyConfigurationException;
use EXACTSports\Spotify\Exceptions\SpotifyConnectionException;
use EXACTSports\Spotify\Models\SpotifyUserInterface;
use EXACTSports\Spotify\Request\Dto\SearchTrackRequestDto;
use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use EXACTSports\Spotify\Response\BaseSpotifyResponse;
use EXACTSports\Spotify\Response\TracksResponse;

class Spotify
{

    private SpotifyClient $spotifyClient;

    /**
     * @throws MissingSpotifyConfigurationException
     */
    public function __construct()
    {
        $this->spotifyClient = new SpotifyClient();
        $this->validateConfig();
    }

    /**
     * @throws MissingSpotifyConfigurationException
     */
    private function validateConfig(): void
    {
        $client_id = config('spotify.client_id');
        $client_secret = config('spotify.client_secret');
        $redirect = config('spotify.redirect');
        if (!$client_id || !$client_secret || !$redirect) {
            throw new MissingSpotifyConfigurationException("Please configure spotify service. Set client_id, client_secret and redirect");
        }
    }

    /**
     * @throws MissingSpotifyConfigurationException
     * @throws SpotifyConnectionException
     */
    public function getUserTopItems(TopItemsRequestDto $requestDto = new TopItemsRequestDto()): BaseSpotifyResponse
    {
        $this->validateUserInterface();
        return $this->spotifyClient->getUserTopItems($requestDto);
    }

    /**
     * @throws MissingSpotifyConfigurationException
     */
    public function searchTracks(SearchTrackRequestDto $requestDto): TracksResponse
    {
        $this->validateUserInterface();
        return $this->spotifyClient->searchTracks($requestDto);
    }

    public function getArtist(string $id): void
    {
        //@todo add implementation
    }

    public function getTrack(string $id): void
    {
        //@todo add implementation
    }

    public function addTracksToPlaylist(): void
    {
        //@todo add implementation
    }
    public function createNewPlaylist(): void
    {
        //@todo add implementation
    }

    /**
     * @throws MissingSpotifyConfigurationException
     */
    private function validateUserInterface(): void
    {
        $user = \Auth::user();
        if (!$user instanceof SpotifyUserInterface) {
            throw new MissingSpotifyConfigurationException("User doesn't implement SpotifyUserInterface");
        }
    }
}