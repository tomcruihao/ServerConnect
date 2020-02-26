<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);
  
  $getLogJsonData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogJsonData, true);

  $dateRange = json_decode($_GET["searchRange"], true);
  $startTime = new DateTime($dateRange["startDate"]);
  $endTime = new DateTime($dateRange["endDate"]);
  $endTime = date_modify($endTime, '+1 day');

  $generateType = $dateRange["type"];

  // filter the log data
  $clickedData_filtered_by_date = [];
  foreach($logData['log'] as $log) {
    $logDateTime = strtotime($log['clickedDateTime']);
    $processedStartTime = strtotime($startTime->format('Y-m-d'));
    $processedEndTime = strtotime($endTime->format('Y-m-d'));

    if($logDateTime >= $processedStartTime && $logDateTime <= $processedEndTime) {
      array_push($clickedData_filtered_by_date, $log);
    }
  }

  // create map
  $resourceIdArray = [];
  foreach($resourceData['rows'] as $resource) {
    $resourceIdArray[$resource['id']] = $resource['resourceName'];
  }

  if($generateType === 'month') {
    $interval= new DateInterval('P1D');
    $dateFormat = 'Y-m';
  } else if($generateType === 'day') {
    $interval= new DateInterval('P1M');
    $dateFormat = 'Y-m-d';
  }

  // create an array which the key is period of date/month
  $report_date = array_period($interval, $dateFormat, $startTime, $endTime);
  print_r($report_date);

  function array_period($interval, $dateFormat, $startTime, $endTime) {
    $array_result = [];
    $period = new DatePeriod($startTime, $interval, $endTime);

    foreach ($period as $key => $value) {
      $array_result[$value->format($dateFormat)] = [];
    }
    return $array_result;
  }
  


  // create log counting array
  foreach($clickedData_filtered_by_date as $log) {
    $ary_tempDate = explode(" ", $log['clickedDateTime']);
    $date = $ary_tempDate[0];

    if (array_key_exists($log['id'], $report_date[$date])) {
      $report_date[$date][$log['id']]['clickTimes']++;
    }
    else {
      $report_date[$date][$log['id']]['name'] = $resourceIdArray[$log['id']];
      $report_date[$date][$log['id']]['clickTimes'] = 1;
    }
  }
  echo json_encode($report_date, JSON_UNESCAPED_UNICODE);
?>
