<?php

namespace src;

use DateTime;
use exception\NoDataException;
use src\OnboardingDataEntity;

class WeeklyData implements Dataset
{
    private $dataset = [];

    public function setData(array $data): void
    {
        if(empty($data))    {
            throw new NoDataException("Empty Data Array");
        }
        foreach ($data as $row) {
            $postDate = new DateTime($row['1']);
            $week = $postDate->format('Y-W');
            $this->dataset[$week][] = new OnboardingDataEntity($row[0], $postDate, (int) $row[2], $row[3], $row[4]);
        }
    }

    public function getAllData(): array
    {
        return $this->dataset;
    }
}