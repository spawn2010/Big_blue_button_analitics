<?php

namespace App\Domain;

use BigBlueButton\BigBlueButton;

class MeetingsDomain
{

    private BigBlueButton $bbb;

    public function __construct(BigBlueButton $container)
    {
        $this->bbb = $container;
    }

    /**
     *  массив с конференциями и их параметрами + средняя продолжительность и количество участников на текущий момент по умолчанию
     */
    public function getMeetingsInfo($param = '')
    {
        return $this->bbb->getMeetings();
    }

    public function getMeetings($param = '')
    {
        return $this->bbb->getMeetings();
    }

    public function getMeetingInfo($id)
    {

    }

}