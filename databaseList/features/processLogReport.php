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

  echo $startTime;
  echo $endTime;

  // filter the log data
  $clickedData_filtered_by_date = [];
  foreach($logData['log'] as $log) {
    $logDateTime = strtotime($log['clickedDateTime']);
    if(strtotime($logDateTime) >= $startTime && $logDateTime <= strtotime($endTime)) {
      array_push($clickedData_filtered_by_date, $log);
    }
  }

  // create map
  $resourceIdArray = [];
  foreach($resourceData['rows'] as $resource) {
    $resourceIdArray[$resource['id']] = $resource['resourceName'];
  }

  // create period of date
  $report_date = [];
  $interval = new DateInterval('P1D');
  $period = new DatePeriod($startTime, $interval, $endTime);
  foreach ($period as $key => $value) {
    $report_date[$value->format('Y-m-d')] = [];
  }

  // create log counting array
  // $clickCountingAry = [];
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
  print_r($report_date);
?>
