<?php

namespace Shouty;

class Shouty
{
    const MESSAGE_RANGE = 1000;

    private $locationsByPersonName = [];
    private $messagesByPersonName = [];

    public function setLocation($personName, $location)
    {
        $this->locationsByPersonName[$personName] = $location;
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
            return $this->areDifferentPeople($firstPersonName, $secondPersonName)
                && $this->arePeopleWithinRange($firstPersonName, $secondPersonName);
        };
    }

    private function areDifferentPeople($firstPersonName, $secondPersonName)
    {
        return $firstPersonName !== $secondPersonName;
    }

    private function arePeopleWithinRange($firstPersonName, $secondPersonName)
    {
        return $this->distanceBetween($firstPersonName, $secondPersonName)->isLessThan($this->messageRange());
    }

    private function distanceBetween($firstPersonName, $secondPersonName)
    {
        return $this->locationsByPersonName[$firstPersonName]->distanceFrom($this->locationsByPersonName[$secondPersonName]);
    }

    private function messageRange()
    {
        return new Distance(self::MESSAGE_RANGE);
    }
}
