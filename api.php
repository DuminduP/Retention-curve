<?php

use src\ManageData;
use src\ReadCsv;
use src\WeeklyData;

include_once 'bootstrap.php';

$readCsv = new ReadCsv('export.csv');
$data = $readCsv->getData();

$weeklyData = new WeeklyData();
$weeklyData->setData($data);

$manageData = new ManageData($weeklyData);
$weeklyStats = $manageData->getRetentionStats();

header('Content-type: application/json');
echo json_encode($weeklyStats);