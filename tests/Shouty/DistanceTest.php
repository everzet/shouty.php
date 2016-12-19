<?php

namespace Shouty;

use PHPUnit\Framework\TestCase;

class DistanceTest extends TestCase
{
    public function testItWorksOutIfItIsLessThanAnotherDistance()
    {
        $a = new Distance(1000);
        $b = new Distance(1100);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($b->isLessThan($a));
    }
}
