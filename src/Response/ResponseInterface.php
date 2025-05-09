<?php

namespace EXACTSports\Spotify\Response;

interface ResponseInterface
{
    /**
     * Get the response data
     * 
     * @return array
     */
    public function getData(): array;
}