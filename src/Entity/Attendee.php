<?php

namespace App\Entity;

class Attendee
{
    private $fullName;
    private $internalId;
    private $role;


    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getInternalId()
    {
        return $this->internalId;
    }

    public function setInternalId($internalId)
    {
        $this->internalId = $internalId;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public static function createFromArray($attributes): Attendee
    {

        $attendee = new self();
        $attendee->setFullName($attributes['fullName']);
        $attendee->setInternalId($attributes['userId']);
        $attendee->setRole($attributes['role']);

        return $attendee;
    }

}