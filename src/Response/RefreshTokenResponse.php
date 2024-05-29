<?php

namespace EXACTSports\Spotify\Response;

final readonly class RefreshTokenResponse implements ResponseInterface
{
    public function __construct(private string $token)
    {

    }

    public function getToken(): string
    {
        return $this->token;
    }
}