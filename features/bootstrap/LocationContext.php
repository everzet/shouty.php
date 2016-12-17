<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

require_once 'src/Shouty/Shouty.php';
require_once 'src/Shouty/Coordinate.php';

use Shouty\Shouty;
use Shouty\Coordinate;

class LocationContext implements Context, SnippetAcceptingContext
{
    private $shouty;

    public function setShouty($shouty)
    {
        $this->shouty = $shouty;
    }

    /**
     * @Given :personName is at [:xCoord, :yCoord]
     */
    public function personIsAt($personName, $xCoord, $yCoord)
    {
        $this->shouty->setLocation($personName, new Coordinate($xCoord, $yCoord));
    }

    /**
     * @Given people are located at
     */
    public function peopleAreLocatedAt(TableNode $peopleLocations)
    {
        foreach($peopleLocations as $personLocation) {
            $this->shouty->setLocation($personLocation['name'], new Coordinate($personLocation['x'], $personLocation['y']));
        }

    }
}
