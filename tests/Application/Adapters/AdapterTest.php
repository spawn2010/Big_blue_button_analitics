<?php

namespace Tests\Application\Adapters;

use App\Adapter\Adapter;
use App\Entity\Meeting;
use PHPUnit\Framework\TestCase;

class AdapterTest extends TestCase
{
    private Adapter $adapter;

    public function setUp(): void
    {

        $xml = simplexml_load_string(file_get_contents(dirname(__DIR__) . '/../fixtures/get_meeting_info.xml'));
        $objectFromApi = (new \BigBlueButton\Responses\GetMeetingInfoResponse($xml))->getMeeting();
        $this->adapter = new Adapter($objectFromApi, [], Meeting::class);
    }

    public function testToEntity()
    {
        $this->assertInstanceOf(Meeting::class, $this->adapter->toEntity());
        $info = $this->adapter->toEntity();
        $data = [
            'Mock meeting for testing getMeetingInfo API method',
            '117b12ae2656972d330b6bad58878541-28-15',
            '178757fcedd9449054536162cdfe861ddebc70ba-1453206317376',
            1453206317380,
            'Tue Jan 19 07:25:17 EST 2016',
            true,
            1453206317376,
            1453206325002,
            20,
            20,
            4,
        ];
        $meetingInfo = [
            $info->getMeetingName(),
            $info->getMeetingId(),
            $info->getInternalMeetingId(),
            $info->getStartTime(),
            $info->getCreationDate(),
            $info->getRunning(),
            $info->getCreationTime(),
            $info->getEndTime(),
            $info->getDuration(),
            $info->getMaxUsers(),
            count($info->getAttendees())
        ];
        $this->assertEquals($data, $meetingInfo);
    }
}