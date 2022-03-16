<?php

namespace App\Service;

use App\Adapter\AttendeeAdapter;
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
        $this->meetings = $meetings->getMeetings()->getMeetings();
        //        echo '<pre>';
//    print_r($this->connection->createQueryBuilder()->select('*')->from('users')->fetchAllAssociative());
//        echo '</pre>';
    }

    public function refresh()
    {
        foreach ($this->meetings as $meeting) {
            $meeting = (new MeetingAdapter($meeting))->toEntity();
            foreach ($meeting->getAttendees() as $attendee) {
                $attendee = (new AttendeeAdapter($attendee))->toEntity();
                if (!$this->exist($attendee->getInternalId(), 'users', 'internalId')) {
                    $this->connection->createQueryBuilder()
                        ->insert('users')
                        ->values([
                            'fullName' => '?',
                            'internalId' => '?',
                            'role' => '?',
                        ])
                        ->setParameters([
                            0 => $attendee->getFullName(),
                            1 => $attendee->getInternalId(),
                            2 => $attendee->getRole(),
                        ])
                        ->executeQuery();
                }
                if (!$this->exist($meeting->getInternalMeetingId(), 'logs', 'meetingId')) {
                    $this->connection->createQueryBuilder()
                        ->insert('logs')
                        ->values([
                            'userId' => '?',
                            'meetingId' => '?',
                        ])
                        ->setParameters([
                            0 => $attendee->getInternalId(),
                            1 => $meeting->getInternalMeetingId(),
                        ])
                        ->executeQuery();
                }
            }
            if ($this->exist($meeting->getInternalMeetingId(), 'meetings', 'internalMeetingId')) {
                $query = $this->connection->createQueryBuilder()
                    ->update('meetings')
                    ->set('running', '?')
                    ->set('duration', '?')
                    ->set('maxUsers', '?')
                    ->set('endTime', '?')
                    ->where("internalMeetingId = ?")
                    ->setParameters([
                        0 => $meeting->getRunning(),
                        1 => $meeting->getDuration(),
                        2 => $meeting->getMaxUsers(),
                        3 => $meeting->getEndTime(),
                        4 => $meeting->getInternalMeetingId()
                    ])
                    ->executeQuery();
                continue;
            }
            $this->connection->createQueryBuilder()
                ->insert('meetings')
                ->values([
                    'meetingName' => '?',
                    'meetingId' => '?',
                    'internalMeetingId' => '?',
                    'startTime' => '?',
                    'createDate' => '?',
                    'running' => '?',
                    'createTime' => '?',
                    'endTime' => '?',
                    'duration' => '?',
                    'maxUsers' => '?',
                ])
                ->setParameters([
                    0 => $meeting->getMeetingName(),
                    1 => $meeting->getMeetingId(),
                    2 => $meeting->getInternalMeetingId(),
                    3 => $meeting->getStartTime(),
                    4 => $meeting->getCreationDate(),
                    5 => $meeting->getRunning(),
                    6 => $meeting->getCreationTime(),
                    7 => $meeting->getEndTime(),
                    8 => $meeting->getDuration(),
                    9 => $meeting->getMaxUsers()
                ])
                ->executeQuery();
        }
    }

    public function exist($value, $tableName, $param)
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($tableName)
            ->where("$param = ?")
            ->setParameter(0, $value)->fetchAllNumeric();
    }
}