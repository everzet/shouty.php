<?php

namespace Shouty;

use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    /**
     * @var Map
     */
    private $map;

    protected function setUp()
    {
        $this->map = new Map();
        $this->map->setLocation('Sean', new Coordinate(0, 0));
        $this->map->setLocation('Oscar', new Coordinate(0, 200));
        $this->map->setLocation('John', new Coordinate(10, 200));
        $this->map->setLocation('Lucy', new Coordinate(1000, 200));
    }

    public function testItListsPeopleAround()
    {
        $peopleAround = $this->map->peopleAround('Sean', $this->exampleDistance());

        $this->assertContains('Oscar', $peopleAround);
        $this->assertContains('John', $peopleAround);
    }

    public function testItDoesNotListPeopleOutsideRange()
    {
        $peopleAround = $this->map->peopleAround('Sean', $this->exampleDistance());

        $this->assertNotContains('Lucy', $peopleAround);
    }

    public function testItDoesNotListThePersonHimself()
    {
        $peopleAround = $this->map->peopleAround('Sean', $this->exampleDistance());

        $this->assertNotContains('Sean', $peopleAround);
    }

    private function exampleDistance()
    {
        return new Distance(1000);
    }
}
