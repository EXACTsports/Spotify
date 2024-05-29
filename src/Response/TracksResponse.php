<?php

namespace EXACTSports\Spotify\Response;

class TracksResponse implements ResponseInterface
{
    public function __construct(private array $tracks = [])
    {

    }

    public function getTracks(): array
    {
        return  $this->tracks;
    }
}