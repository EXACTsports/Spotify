<?php

namespace EXACTSports\Spotify\Facade;

use Illuminate\Support\Facades\Facade;

class Spotify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Spotify';
    }

}