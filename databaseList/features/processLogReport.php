<?php
  include '_header.php';

  include 'verifyToken.php';

  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);

  $getIdentity = file_get_contents('../data/authIdentity.json');
  $identityData = json_decode($getIdentity, true);

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

  // create map and countable template
  $template = [];
  foreach($resourceData as $resource) {
    $template[$resource['uuid']] = array(
      "name" => $resource['local']['resourceName'],
      "clickTimes" => 0,
    );
    $template['total'] = 0;
  }

  // choose date formate
  if($generateType === 'month') {
    $interval= new DateInterval('P1M');
    $dateFormat = 'Y-m';
  } else if($generateType === 'day') {
    $interval= new DateInterval('P1D');
    $dateFormat = 'Y-m-d';
  }

  if($generateType === 'month' || $generateType === 'day') {
    // create an array which the key is period of date/month
    $report = array_period($interval, $dateFormat, $startTime, $endTime);
    foreach($report as $key => $field) {
      $report[$key] = new ArrayObject($template);
    }

    // create log counting array
    foreach($clickedData_filtered_by_date as $log) {
      $logDateTime = new DateTime($log['clickedDateTime']);
      $string_time = $logDateTime->format($dateFormat);

      $report[$string_time][$log['uuid']]['clickTimes']++;
      $report[$string_time]['total']++;
    }
  } else if($generateType === 'userDepartment' || $generateType === 'userIdentity') {
    $report = array_identityAndDepartment($generateType, $identityData);
    foreach($report as $key => $field) {
      $report[$key] = new ArrayObject($template);
    }

    // for N/A value
    $report['other'] = new ArrayObject($template);

    // create log counting array
    foreach($clickedData_filtered_by_date as $log) {
      if(strcmp($log[$generateType], "N/A") == 0) {
        $report['other'][$log['uuid']]['clickTimes']++;
        $report['other']['total']++;
      } else {
        $report[$log[$generateType]][$log['uuid']]['clickTimes']++;
        $report[$log[$generateType]]['total']++;
      }
    }

    $report = array_replaceIdentityKeyName($generateType, $report, $identityData);
  }

  $response = [];
  $response['status'] = 'success';
  $response['report'] = $report;

  echo json_encode($response, JSON_UNESCAPED_UNICODE);

  function array_replaceIdentityKeyName($generateType, $array_original, $array_reference) {
    $array_result = [];
    
    foreach ($array_original as $key => $value) {
      foreach ($array_reference[$generateType] as $rkey => $rValue) {
        if($rValue['id'] === $key) {
          $array_result[$rValue['name']] = $value;
        }
      }
    }

    $array_result['other'] = $array_original['other'];

    return $array_result;
  }

  function array_identityAndDepartment($type, $identityData) {
    $array_result = [];

    foreach ($identityData[$type] as $key => $value) {
      // if delete mark not in array then add it to result
      if (!array_key_exists('deleted', $value)) {
        $array_result[$value["id"]] = [];
      }
    }
    return $array_result;
  }

  function array_period($interval, $dateFormat, $startTime, $endTime) {
    $array_result = [];
    $period = new DatePeriod($startTime, $interval, $endTime);

    foreach ($period as $key => $value) {
      $array_result[$value->format($dateFormat)] = [];
    }
    return $array_result;
  }
?>
