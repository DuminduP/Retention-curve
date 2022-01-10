<?php

namespace src;

use Exception;
use exception\FileNotFoundException;

class ReadCsv
{

    private $fileHandle;

    public function __construct(string $fileName)
    {
        if (($this->fileHandle = fopen($fileName, "r")) === false) {
            throw new FileNotFoundException("File \"$fileName\" could not be found or not readable");
        }
    }

    public function getData(): array
    {
        $row = 1;
        $dataSet = [];
        while (($data = fgetcsv($this->fileHandle, 1000, ";")) !== false) {
            if ($row == 1) {
                $keys = $data;
                $row++;
                continue;
            }
            $dataSet[] = [
                $keys[0] => $data[0],
                $keys[1] => $data[1],
                $keys[2] => $data[2],
                $keys[3] => $data[3],
                $keys[4] => $data[4],
            ];
            $row++;
        }
        fclose($this->fileHandle);
        return $dataSet;
    }

}
