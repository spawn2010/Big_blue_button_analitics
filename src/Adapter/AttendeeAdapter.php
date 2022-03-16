<?php

namespace App\Adapter;

class AttendeeAdapter extends Adapter
{
    public function __construct(\BigBlueButton\Core\Attendee $attendee, $excludeProperties = [])
    {
        parent::__construct($attendee, $excludeProperties);
    }
}