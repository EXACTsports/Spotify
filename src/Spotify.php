<?php

namespace EXACTSports\Spotify;

class Spotify
{
    public static function validateConfig(): void
    {
       $client_id = config('spotify.client_id');
       $client_secret = config('spotify.client_secret');
       $redirect = config('spotify.redirect');
    }
}