<?php

namespace EXACTSports\Spotify\Request;

use EXACTSports\Spotify\Response\ResponseInterface;

interface RequestInterface
{
    public function execute(): ResponseInterface;
}