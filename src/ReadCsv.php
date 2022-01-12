<?php

namespace src;

use exception\FileNotFoundException;
use exception\NoDataException;

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
        $dataSet = [];
        $headers = fgetcsv($this->fileHandle, 1000, ";"); //Read headers
        if ($headers === false) {
            throw new NoDataException("Empty file or unsupported format");
        }
        while (($data = fgetcsv($this->fileHandle, 1000, ";")) !== false) {
            $dataSet[] = $data;
        }
        fclose($this->fileHandle);
        return $dataSet;
    }

}
