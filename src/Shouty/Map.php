<?php

namespace Shouty;

class Map
{
    private $locationsByPersonName = [];

    public function setLocation($personName, $location)
    {
        $this->locationsByPersonName[$personName] = $location;
    }

    public function peopleAround($subjectName, $range)
    {
        return array_keys(
            array_filter(
                $this->locationsByPersonName,
                function ($personName) use ($subjectName, $range) {
                    return $this->areDifferentPeople($personName, $subjectName)
                        && $this->arePeopleWithinRange($personName, $subjectName, $range);
                },
                ARRAY_FILTER_USE_KEY
            )
        );
    }

    private function areDifferentPeople($firstPersonName, $secondPersonName)
    {
        return $firstPersonName !== $secondPersonName;
    }

    private function arePeopleWithinRange($firstPersonName, $secondPersonName, $range)
    {
        return $this->distanceBetween($firstPersonName, $secondPersonName)->isLessThan($range);
    }

    private function distanceBetween($firstPersonName, $secondPersonName)
    {
        return $this->locationsByPersonName[$firstPersonName]->distanceFrom($this->locationsByPersonName[$secondPersonName]);
    }
}
