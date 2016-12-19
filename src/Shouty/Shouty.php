<?php

namespace Shouty;

class Shouty
{
    const MESSAGE_RANGE = 1000;

    private $map;
    private $messages;

    public function __construct()
    {
        $this->map = new Map();
        $this->messages = new Messages();
    }

    public function setLocation($personName, $location)
    {
        $this->map->setLocation($personName, $location);
    }

    public function shout($shouterName, $message)
    {
        $this->messages->add($shouterName, $message);
    }

    public function getMessagesHeardBy($listenerName)
    {
        return $this->messages->fromPeople($this->map->peopleAround($listenerName, new Distance(self::MESSAGE_RANGE)));
    }
}
