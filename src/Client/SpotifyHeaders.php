<?php

namespace EXACTSports\Spotify\Client;

class SpotifyHeaders
{
    private string $accept = 'application/json';

    public function __construct(private string $authorization, private string $contentType = 'application/json')
    {

    }

    public function toArray(): array
    {
        return [
            'Content-Type' => $this->contentType,
            'Authorization' => $this->authorization,
            'Accept' => $this->accept
        ];
    }


}