<?php

namespace App\Service;

use App\Adapter\MeetingAdapter;
use App\Entity\Meeting;
use BigBlueButton\BigBlueButton;
use Doctrine\DBAL\Connection;

class WriteService
{
    private $meetings;
    private Connection $connection;

    public function __construct(Connection $connection, BigBlueButton $meetings)
    {
       $this->connection = $connection;
       $this->meetings = $meetings->getMeetings()->getMeetings()[0];
    }

    public function refresh()
    {

       $meeting = (new MeetingAdapter($this->meetings))->toEntity();

    }

    public function exist()
    {
        /**
         * проверка на существование, необходима для определения добавления или обновления данных
         */
    }
}