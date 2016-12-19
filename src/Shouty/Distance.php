<?php

namespace Shouty;

class Distance
{
    private $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function isLessThan(Distance $distance)
    {
        return $this->number < $distance->number;
    }
}
