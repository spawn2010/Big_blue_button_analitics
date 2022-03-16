<?php

namespace App\Entity;

use BigBlueButton\BigBlueButton;

class Meeting
{
    private BigBlueButton $meeting;
    private $meetingName;
    private $meetingId;
    private $internalMeetingId;
    private $startTime;
    private $creationDate;
    private $isRunning;
    private $creationTime;
    private $endTime;
    private $duration;
    private $maxUsers;
    private $attendees;


    public function getMeetingName()
    {
        return $this->meetingName;
    }

    public function setMeetingName($meetingName)
    {
        $this->meetingName = $meetingName;
    }

    public function getMeetingId()
    {
        return $this->meetingId;
    }

    public function setMeetingId($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function getInternalMeetingId()
    {
        return $this->internalMeetingId;
    }

    public function setInternalMeetingId($internalMeetingId)
    {
        $this->internalMeetingId = $internalMeetingId;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getRunning()
    {
        return $this->isRunning;
    }

    public function setRunning($isRunning)
    {
        $this->isRunning = $isRunning;
    }

    public function getCreationTime()
    {
        return $this->creationTime;
    }

    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getMaxUsers()
    {
        return $this->maxUsers;
    }

    public function setMaxUsers($maxUsers)
    {
        $this->maxUsers = $maxUsers;
    }

    public function getAttendees()
    {
        return $this->attendees;
    }

    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;
    }

    public static function createFromArray($attributes): Meeting
    {

        $meeting = new self();
        $meeting->setMeetingName($attributes['meetingName']);
        $meeting->setMeetingId($attributes['meetingId']);
        $meeting->setInternalMeetingId($attributes['internalMeetingId']);
        $meeting->setStartTime($attributes['startTime']);
        $meeting->setCreationDate($attributes['creationDate']);
        $meeting->setRunning($attributes['isRunning']);
        $meeting->setCreationTime($attributes['creationTime']);
        $meeting->setEndTime($attributes['endTime']);
        $meeting->setDuration($attributes['duration']);
        $meeting->setMaxUsers($attributes['maxUsers']);
        $meeting->setAttendees($attributes['attendees']);

        return $meeting;
    }

}