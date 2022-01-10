<?php
use PHPUnit\Framework\TestCase;
use \src\ManageData;

class ManageDataTest extends TestCase
{
    private $validaData = [
        ['user_id' => 3525, 'created_at' => '2016-08-10', 'onboarding_perentage' => 99],
        ['user_id' => 3526, 'created_at' => '2016-08-11', 'onboarding_perentage' => 80],
        ['user_id' => 3527, 'created_at' => '2016-09-01', 'onboarding_perentage' => 50],
    ];

    public function testCanBeCreatedFromValidData(): void
    {
        $this->assertInstanceOf(
            ManageData::class,
            new ManageData($this->validaData)
        );
    }

    public function testWeeklyData(): void
    {
        $manageData = new ManageData($this->validaData);
        $weeklyData = $manageData->getWeeklyData();
        $this->assertIsArray($weeklyData);
        $this->assertCount(2, $weeklyData);
        $this->assertArrayHasKey('user_id', $weeklyData['2016-32'][0]);
        $this->assertArrayHasKey('created_at', $weeklyData['2016-32'][0]);
        $this->assertArrayHasKey('onboarding_perentage', $weeklyData['2016-32'][0]);
        $this->assertEquals(3525, $weeklyData['2016-32'][0]['user_id']);
        $this->assertEquals('2016-08-10', $weeklyData['2016-32'][0]['created_at']);
        $this->assertEquals(99, $weeklyData['2016-32'][0]['onboarding_perentage']);
    }

    public function testWeeklyCount(): void
    {
        $manageData = new ManageData($this->validaData);
        $weeklyData = $manageData->getWeeklyData();
        $weeklyCount = $manageData->getWeeklyCount();
        $this->assertIsArray($weeklyCount);
        $this->assertCount(2, $weeklyCount);
        $this->assertArrayHasKey('2016-32', $weeklyCount);
        $this->assertArrayHasKey(99, $weeklyCount['2016-32']);
        $this->assertArrayHasKey(80, $weeklyCount['2016-32']);
        $this->assertArrayHasKey(50, $weeklyCount['2016-35']);
        $this->assertEquals(1, $weeklyCount['2016-35'][50]);
    }

    public function testWeeklyStats(): void
    {
        $manageData = new ManageData($this->validaData);
        $weeklyData = $manageData->getWeeklyData();
        $weeklyCount = $manageData->getWeeklyCount();
        $weeklyStats = $manageData->getWeeklyStats();
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
