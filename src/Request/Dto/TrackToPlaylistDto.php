<?php

namespace EXACTSports\Spotify\Request\Dto;

class TrackToPlaylistDto
{
    public function __construct(
        public string $playlistId,
        public array  $uris,
        public int    $position = 0
    )
    {

    }

    public function toArray(): array
    {
        return [
            'uris' => $this->uris,
            'position' => $this->position,
        ];
    }
}