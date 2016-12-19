<?php

namespace Shouty;

class Messages
{
    private $messagesByPersonName = [];

    public function add($personName, $message)
    {
        if (!isset($this->messagesByPersonName[$personName])) {
            $this->messagesByPersonName[$personName] = [];
        }

        $this->messagesByPersonName[$personName][] = $message;
    }

    public function fromPeople($people)
    {
        return array_map(
            [$this, 'personMessages'],
            array_filter(
                array_combine($people, $people),
                [$this, 'personHasMessages']
            )
        );
    }

    private function personMessages($personName)
    {
        return $this->messagesByPersonName[$personName];
    }

    private function personHasMessages($personName)
    {
        return isset($this->messagesByPersonName[$personName]);
    }
}
