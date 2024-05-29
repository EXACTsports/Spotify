<?php

namespace EXACTSports\Spotify\Facade;

use EXACTSports\Spotify\Request\Dto\TopItemsRequestDto;
use Illuminate\Support\Facades\Facade;

/**
 * @method static getUserTopItems(TopItemsRequestDto $requestDto)
 */
class Spotify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Spotify';
    }

}