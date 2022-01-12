<?php
use exception\NoDataException;
use PHPUnit\Framework\TestCase;
use \src\ReadCsv;

class ReadCsvTest extends TestCase
{
    public function testCreatedWithValidCsvFile(): void
    {
        $this->assertInstanceOf(
            ReadCsv::class,
            new ReadCsv('export.csv')
        );
    }

    public function testCreatedWithInvalidCsvFile(): void
    {
        $this->expectException(NoDataException::class);
        $tmp = new ReadCsv('tests/testempty.csv');
        $tmp->getData();
    }

    public function testValidDataSet(): void
    {
        $readCsv = new ReadCsv('tests/testdata.csv');
        $data = $readCsv->getData();
        $this->assertIsArray($data);
        $this->assertCount(3, $data);
        $this->assertEquals(3525, $data[0]['0']);
        $this->assertEquals('2016-08-10', $data[0][1]);
        $this->assertEquals(99, $data[0]['2']);
    }

}
