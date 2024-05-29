<?php

namespace EXACTSports\Spotify\Response;

final readonly class BaseSpotifyResponse implements ResponseInterface
{
    public function __construct(private mixed $data)
    {

    }

    public function getData(): mixed
    {
        return $this->data;
    }
}