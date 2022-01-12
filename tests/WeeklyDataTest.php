<?php
use exception\NoDataException;
use PHPUnit\Framework\TestCase;
use src\OnboardingDataEntity;
use \src\WeeklyData;

class WeeklyDataTest extends TestCase
{
    private $dataSet;

    protected function setUp(): void
    {
        $this->dataSet = [
            [3525, '2016-08-10', 99, 0, 0],
            [3526, '2016-08-11', 80, 0, 0],
            [3527, '2016-09-01', 50, 0, 0],
        ];

    }

    public function testCreatedWithValidCsvFile(): void
    {
        $this->assertInstanceOf(
            WeeklyData::class,
            new WeeklyData($this->dataSet)
        );
    }

    public function testCreatedWithInvalidCsvFile(): void
    {
        $data = [];
        $this->expectException(NoDataException::class);
        $tmp = new WeeklyData();
        $tmp->setData($data);
    }

    public function testValidDataSet(): void
    {
        $weeklyDataObj = new WeeklyData();
        $weeklyDataObj->setData($this->dataSet);
        $data = $weeklyDataObj->getAllData();
        $this->assertIsArray($data);
        $this->assertCount(2, $data);
        $firstRec = array_shift($data);
        $this->assertIsObject($firstRec[0]);
        $this->assertInstanceOf(
            OnboardingDataEntity::class,
            $firstRec[0]
        );
        $this->assertEquals(3525, $firstRec[0]->user_id);
        $this->assertEquals('2016-08-10', $firstRec[0]->created_at->format('Y-m-d'));
        $this->assertEquals(99, $firstRec[0]->onboarding_percentage);
    }

}
