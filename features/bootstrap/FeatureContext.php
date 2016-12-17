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
    private $shoutyHelper;

    public function setShoutyHelper($shoutyHelper)
    {
        $shoutyHelper->reset();
        $this->shoutyHelper = $shoutyHelper;
    }

    /**
     * @When :shouterName shouts
     */
    public function shouterShouts($shouterName)
    {
        $this->getShouty()->shout($shouterName, self::ARBITRARY_MESSAGE);
    }

    /**
     * @Then Lucy should hear Sean
     */
    public function lucyShouldHearSean()
    {
        PHPUnit::assertEquals(1, count($this->getShouty()->getMessagesHeardBy("Lucy")));
    }

    /**
     * @Then Lucy should hear nothing
     */
    public function lucyShouldHearNothing()
    {
        PHPUnit::assertEquals(0, count($this->getShouty()->getMessagesHeardBy("Lucy")));
    }

    /**
     * @Then :listenerName should not hear :shouterName
     */
    public function listenerShouldNotHearShouter($listenerName, $shouterName)
    {
        $messages = $this->getShouty()->getMessagesHeardBy($listenerName);

        PHPUnit::assertFalse(array_key_exists($shouterName, $messages), "Did not expect to hear: " . $shouterName . ", but did!");
    }

    /**
     * @Then :listenerName should hear :countOfShouts shouts from :shouterName
     */
    public function lucyShouldHearShoutsFromSean($countOfShouts, $listenerName, $shouterName)
    {
        $messages = $this->getShouty()->getMessagesHeardBy($listenerName);
        $messagesByShouter = $messages[$shouterName];

        PHPUnit::assertEquals(intval($countOfShouts), count($messagesByShouter));
    }

    private function getShouty()
    {
        return $this->shoutyHelper->getShouty();
    }
}
