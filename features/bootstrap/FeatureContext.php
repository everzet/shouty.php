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

class FeatureContext implements Context, SnippetAcceptingContext
{
    const ARBITRARY_MESSAGE = 'Hello, world';
    private $shouty;

    public function __construct()
    {
        $this->shouty = new Shouty();
    }

    /**
     * @Given :personName is at [:xCoord, :yCoord]
     */
    public function personIsAt($personName, $xCoord, $yCoord)
    {
        $this->shouty->setLocation($personName, new Coordinate($xCoord, $yCoord));
    }

    /**
     * @When :shouterName shouts
     */
    public function shouterShouts($shouterName)
    {
        $this->shouty->shout($shouterName, self::ARBITRARY_MESSAGE);
    }

    /**
     * @Then Lucy should hear Sean
     */
    public function lucyShouldHearSean()
    {
        PHPUnit::assertEquals(1, count($this->shouty->getMessagesHeardBy("Lucy")));
    }

    /**
     * @Then Lucy should hear nothing
     */
    public function lucyShouldHearNothing()
    {
        PHPUnit::assertEquals(0, count($this->shouty->getMessagesHeardBy("Lucy")));
    }

    /**
     * @Then :listenerName should not hear :shouterName
     */
    public function listenerShouldNotHearShouter($listenerName, $shouterName)
    {
        $messages = $this->shouty->getMessagesHeardBy($listenerName);

        PHPUnit::assertFalse(array_key_exists($shouterName, $messages), "Did not expect to hear: " . $shouterName . ", but did!");
    }
}
