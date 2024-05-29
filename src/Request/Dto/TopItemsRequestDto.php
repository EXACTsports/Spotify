<?php

namespace EXACTSports\Spotify\Request\Dto;

class TopItemsRequestDto
{
    public function __construct(public int $limit = 10, public int $offset = 0, public string $timeRange = 'medium_term')
    {

    }
}