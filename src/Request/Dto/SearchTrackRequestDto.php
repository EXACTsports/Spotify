<?php

namespace EXACTSports\Spotify\Request\Dto;

class SearchTrackRequestDto
{

    public function __construct(public string $search, public int $limit = 5, public string $includeExternal = 'auto')
    {

    }

}