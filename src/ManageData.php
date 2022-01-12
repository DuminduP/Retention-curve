<?php

namespace src;

class ManageData
{
    private $dataset;

    private $prograss = [0 => 0, 10 => 0, 20 => 0, 30 => 0, 40 => 0, 50 => 0, 60 => 0, 70 => 0, 80 => 0, 90 => 0, 100 => 0];

    public function __construct(Dataset $dataObj)
    {
        $this->dataset = $dataObj->getAllData();
    }

    public function getOnboardingPercentageCount(): array
    {
        $out = [];
        foreach ($this->dataset as $key => $value) {
            foreach ($value as $row) {
                if (!empty($row->onboarding_percentage) && !isset($out[$key][$row->onboarding_percentage])) {
                    $out[$key][$row->onboarding_percentage] = 0;
                }
                if (!empty($row->onboarding_percentage)) {
                    $out[$key][$row->onboarding_percentage]++;
                }
            }
        }
        return $out;
    }

    public function getRetentionStats(): array
    {
        $dataCount = $this->getOnboardingPercentageCount();
        $out = [];
        foreach ($dataCount as $key => $data) {
            $out[$key] = $this->calculatePercentage($data);
        }
        return $out;
    }

    private function calculatePercentage(array $data): array
    {
        $prograss = $this->prograss;
        foreach ($data as $pcr => $count) {
            $total = array_sum($data);
            foreach ($prograss as $pct => $n) {
                if ($pct <= $pcr) {
                    $prograss[$pct] += $count;
                }
            }
        }
        foreach ($prograss as &$pcr) {
            $pcr = round(($pcr / $total) * 100, 1);
        }
        return $prograss;
    }

}
