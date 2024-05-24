<?php

namespace EXACTSports\Spotify\Tests\Unit;

use EXACTSports\Spotify\Tests\TestCase;

class HealthCheckTest extends TestCase
{

    public function testOk(): void
    {
        $this->assertSame(1, 1);
    }
}
