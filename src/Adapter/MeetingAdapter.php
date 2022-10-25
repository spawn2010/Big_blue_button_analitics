<?php

namespace App\Adapter;

use BigBlueButton\Core\Meeting;

class MeetingAdapter extends Adapter
{
    public function __construct(\BigBlueButton\Core\Meeting $meeting, $excludeProperties = [])
    {
        parent::__construct($meeting, $excludeProperties, \App\Entity\Meeting::class);
    }
}