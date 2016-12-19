<?php

namespace Shouty;

use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    public function testItListsMessagesFromMultiplePeople()
    {
        $messages = new Messages();
        $messages->add('Sean', 'Hello!');
        $messages->add('Lucy', 'Hi.');

        $this->assertEquals(['Sean' => ['Hello!'], 'Lucy' => ['Hi.']], $messages->fromPeople(['Sean', 'Lucy']));
    }

    public function testItListsMultipleMessagesFromASinglePerson()
    {
        $messages = new Messages();
        $messages->add('Sean', 'Hello,');
        $messages->add('Sean', 'World!');

        $this->assertEquals(['Sean' => ['Hello,', 'World!']], $messages->fromPeople(['Sean']));
    }

    public function testItListsNothingWhenThereAreNoMessages()
    {
        $messages = new Messages();

        $this->assertEquals([], $messages->fromPeople(['Sean']));
    }
}
