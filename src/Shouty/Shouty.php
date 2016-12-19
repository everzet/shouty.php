<?php

namespace Shouty;

class Shouty
{
    const MESSAGE_RANGE = 1000;

    private $map;
    private $messagesByPersonName = [];

    public function __construct()
    {
        $this->map = new Map();
    }

    public function setLocation($personName, $location)
    {
        $this->map->setLocation($personName, $location);
        $this->messagesByPersonName[$personName] = [];
    }

    public function shout($shouterName, $message)
    {
        $this->messagesByPersonName[$shouterName][] = $message;
    }

    public function getMessagesHeardBy($listenerName)
    {
        return array_filter($this->messagesByPersonName, $this->filterPeopleWithinRangeOf($listenerName), ARRAY_FILTER_USE_KEY);
    }

    private function filterPeopleWithinRangeOf($firstPersonName)
    {
        return function ($secondPersonName) use ($firstPersonName) {
            return in_array($secondPersonName, $this->map->peopleAround($firstPersonName, $this->messageRange()));
        };
    }

    private function messageRange()
    {
        return new Distance(self::MESSAGE_RANGE);
    }
}
