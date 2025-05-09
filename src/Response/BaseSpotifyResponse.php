<?php

namespace EXACTSports\Spotify\Response;

final readonly class BaseSpotifyResponse implements ResponseInterface
{
    public function __construct(private array $data)
    {

    }

    public function getData(): array
    {
        return $this->data;
    }
}