<?php

namespace EXACTSports\Spotify\Contracts;

interface SpotifyUserInterface
{
    public function getSpotifyId(): ?string;
    
    public function getSpotifyAccessToken(): ?string;
    public function getSpotifyRefreshToken(): ?string;
    
    public function renewSpotifyToken(string $token): void;
}