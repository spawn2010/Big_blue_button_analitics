<?php

namespace App\Domain;

use BigBlueButton\BigBlueButton;

class IndexDomain
{
    private BigBlueButton $bbb;

    public function __construct(BigBlueButton $container)
    {
        $this->bbb = $container;
    }

    public function insert()
    {

    }

}