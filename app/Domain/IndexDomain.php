<?php

namespace App\Domain;

use BigBlueButton\BigBlueButton;

class IndexDomain
{
    private $meetings;

    public function __construct(BigBlueButton $container)
    {
        $this->meetings = $container->getMeetings()->getMeetings();
    }

    public function insert()
    {

    }

    public function update()
    {

    }

    public function attendeeInsert()
    {

    }

    public function meetingInsert()
    {

    }

    public function logInsert()
    {

    }
    public function attendeeUpdate()
    {

    }

    public function meetingUpdate()
    {

    }

    public function logUpdate()
    {

    }

}