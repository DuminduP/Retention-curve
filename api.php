<?php

use src\ManageData;
use src\ReadCsv;

include_once 'bootstrap.php';

$readCsv = new ReadCsv('export.csv');
$data = $readCsv->getData();

$manageData = new ManageData($data);
$weeklyStats = $manageData->getWeeklyStats();
header('Content-type: application/json');
echo json_encode($weeklyStats);