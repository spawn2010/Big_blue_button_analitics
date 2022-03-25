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

        $xml =  simplexml_load_string(file_get_contents(dirname(__DIR__).'/../fixtures/get_meeting_info.xml'));
        $objectFromApi = (new \BigBlueButton\Responses\GetMeetingInfoResponse($xml))->getMeeting();
        $this->adapter = new Adapter($objectFromApi,[],Meeting::class);
    }

    public function testToEntity()
    {
        $this->assertInstanceOf(Meeting::class,$this->adapter->toEntity());
        $info = $this->adapter->toEntity();
        $this->assertEquals('Mock meeting for testing getMeetingInfo API method', $info->getMeetingName());
        $this->assertEquals('117b12ae2656972d330b6bad58878541-28-15', $info->getMeetingId());
        $this->assertEquals('178757fcedd9449054536162cdfe861ddebc70ba-1453206317376', $info->getInternalMeetingId());
        $this->assertEquals(1453206317380, $info->getStartTime());
        $this->assertEquals('Tue Jan 19 07:25:17 EST 2016', $info->getCreationDate());
        $this->assertEquals(true, $info->getRunning());
        $this->assertEquals(1453206317376, $info->getCreationTime());
        $this->assertEquals(1453206325002, $info->getEndTime());
        $this->assertEquals(20, $info->getDuration());
        $this->assertEquals(20, $info->getMaxUsers());
        $this->assertCount(4, $info->getAttendees());
    }
}