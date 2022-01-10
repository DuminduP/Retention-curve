<?php
use PHPUnit\Framework\TestCase;
use \src\ReadCsv;
use exception\FileNotFoundException;

class ReadCsvTest extends TestCase
{
    public function testCanBeCreatedFromValidCsvFile(): void
    {
        $this->assertInstanceOf(
            ReadCsv::class,
            new ReadCsv('export.csv')
        );
    }

    public function testValidDataSet(): void
    {
        $readCsv = new ReadCsv('export.csv');
        $data = $readCsv->getData();
        $this->assertIsArray($data);
        $this->assertCount(339, $data);
        $this->assertArrayHasKey('user_id', $data[0]);
        $this->assertArrayHasKey('created_at', $data[0]);
        $this->assertArrayHasKey('onboarding_perentage', $data[0]);
        $this->assertEquals(3121,$data[0]['user_id']);
        $this->assertEquals('2016-07-19',$data[0]['created_at']);
        $this->assertEquals(40,$data[0]['onboarding_perentage']);
    }

}