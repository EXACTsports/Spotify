<?php

namespace EXACTSports\Spotify\Request\Dto;

class NewPlaylistDto
{
    public function __construct(
        public string $spotifyId,
        public string $name = 'New Playlist',
        public string $description = 'New Playlist Description',
        public bool $isPublic = true,
        public bool $isCollaborative = false
    )
    {

    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'public' => $this->isPublic,
            'collaborative' => $this->isCollaborative,
            'description' => $this->description,
        ];
    }
}