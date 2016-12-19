<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;
use Shouty\Shouty;
use Shouty\Coordinate;

class LocationContext implements Context, SnippetAcceptingContext
{
    private $shoutyHelper;

    public function setShoutyHelper($shoutyHelper)
    {
        $this->shoutyHelper = $shoutyHelper;
    }

    /**
     * @Transform /\[(\d+), (\d+)\]/
     */
    public function transformCoords($xCoord, $yCoord)
    {
        return new Coordinate($xCoord, $yCoord);
    }

    /**
     * @Given /^(\w+) is at (\[\d+, \d+\])$/
     */
    public function personIsAt($personName, Coordinate $coordinate)
    {
        $this->getShouty()->setLocation($personName, $coordinate);
    }

    /**
     * @Given people are located at
     */
    public function peopleAreLocatedAt(TableNode $peopleLocations)
    {
        foreach($peopleLocations as $personLocation) {
            $this->getShouty()->setLocation($personLocation['name'], new Coordinate($personLocation['x'], $personLocation['y']));
        }

    }

    private function getShouty()
    {
        return $this->shoutyHelper->getShouty();
    }
}