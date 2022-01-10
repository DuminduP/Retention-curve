<?php

namespace src;

use DateTime;

class ManageData
{
    private $dataset;

    private $weeklyData;

    public function __construct(array $data)
    {
        $this->dataset = $data;
    }

    public function getWeeklyData(): array
    {
        $out = [];
        foreach ($this->dataset as $row) {
            $postDate = new DateTime($row['created_at']);
            $week = $postDate->format('Y-W');
            $out[$week][] = $row;
        }
        return $out;
    }

    public function getWeeklyCount(): array
    {
        $out = [];
        $weeklyData = $this->getWeeklyData();
        foreach ($weeklyData as $week => $weekData) {
            foreach ($weekData as $data) {
                if (!empty($data['onboarding_perentage']) && !isset($out[$week][$data['onboarding_perentage']])) {
                    $out[$week][$data['onboarding_perentage']] = 0;
                }
                if (!empty($data['onboarding_perentage'])) {
                    $out[$week][$data['onboarding_perentage']]++;
                }
            }
        }
        return $out;
    }

    public function getWeeklyStats(): array
    {
        $weeklyCount = $this->getWeeklyCount();
        $out = [];
        $precentages = [];
        foreach ($weeklyCount as $week => $weekData) {
            $out[$week] = $this->calculatePercentage($weekData);
        }
        return $out;
    }

    private function calculatePercentage(array $data): array
    {
        $prograss = [0 => 0, 10 => 0, 20 => 0, 30 => 0, 40 => 0, 50 => 0, 60 => 0, 70 => 0, 80 => 0, 90 => 0, 100 => 0];

        foreach($data as $pcr => $count) {
            $total = array_sum($data);
            foreach($prograss as $pct => $n)    {
                if($pct <= $pcr) {
                    $prograss[$pct] += $count;
                }
            }
        }
        foreach($prograss as &$pcr)   {
            $pcr = round(($pcr/$total)*100,1);
        }
        return $prograss;
    }

}
