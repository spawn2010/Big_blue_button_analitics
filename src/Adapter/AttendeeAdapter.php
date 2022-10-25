<?php

namespace App\Adapter;

use App\Entity\Meeting;

class AttendeeAdapter extends Adapter
{
    public function __construct(\BigBlueButton\Core\Attendee $attendee, $excludeProperties = [])
    {
        parent::__construct($attendee, $excludeProperties, \App\Entity\Attendee::class);
    }
}