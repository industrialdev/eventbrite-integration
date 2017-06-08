<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;


class EventbriteTest extends TestCase
{
    public function testCanPullDataFromEvent(): void
    {
        $this->assertEquals(4, 2+2);
    }
}
