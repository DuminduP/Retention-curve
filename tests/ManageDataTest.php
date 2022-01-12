<?php
use PHPUnit\Framework\TestCase;
use \src\ManageData;
use \src\WeeklyData;

class ManageDataTest extends TestCase
{

    private $weeklyDataObj;

    protected function setUp(): void
    {
        $data = [
            [3525, '2016-08-10', 99, 0, 0],
            [3526, '2016-08-11', 80, 0, 0],
            [3527, '2016-09-01', 50, 0, 0],
        ];
        $this->weeklyDataObj = new WeeklyData();
        $this->weeklyDataObj->setData($data);

    }

    public function testGetOnboardingPercentageCount(): void
    {
        $manageData = new ManageData($this->weeklyDataObj);
        $wCount = $manageData->getOnboardingPercentageCount();
        $this->assertIsArray($wCount);
        $this->assertCount(2, $wCount);
        $this->assertArrayHasKey('2016-32', $wCount);
        $this->assertArrayHasKey('2016-35', $wCount);
        $this->assertArrayHasKey(99, $wCount['2016-32']);
        $this->assertArrayHasKey(80, $wCount['2016-32']);
        $this->assertEquals(1, $wCount['2016-32'][99]);
        $this->assertEquals(1, $wCount['2016-32'][80]);
        $this->assertEquals(1, $wCount['2016-35'][50]);
    }

    public function testGetRetentionStats(): void
    {
        $manageData = new ManageData($this->weeklyDataObj);
        $weeklyStats = $manageData->getRetentionStats();
        $this->assertIsArray($weeklyStats);
        $this->assertCount(2, $weeklyStats);
        $this->assertArrayHasKey('2016-32', $weeklyStats);
        $this->assertArrayHasKey(0, $weeklyStats['2016-32']);
        $this->assertArrayHasKey(100, $weeklyStats['2016-32']);
        $this->assertArrayHasKey(50, $weeklyStats['2016-35']);
        $this->assertEquals(100, $weeklyStats['2016-32'][0]);
        $this->assertEquals(0, $weeklyStats['2016-32'][100]);
        $this->assertEquals(50, $weeklyStats['2016-32'][90]);
        $this->assertEquals(100, $weeklyStats['2016-35'][50]);
    }

}
