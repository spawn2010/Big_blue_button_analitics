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

}