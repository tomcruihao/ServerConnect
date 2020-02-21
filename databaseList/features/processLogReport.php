<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);
  

  $getLogJsonData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogJsonData, true);

  // create map
  $resourceIdArray = [];
  foreach($resourceData['rows'] as $resource) {
    $resourceIdArray[$resource['id']] = $resource['resourceName'];
  }
  // print_r($resourceIdArray);

  // create log counting array
  $clickCountingAry = [];
  foreach($logData['log'] as $log) {
    // echo $resourceIdArray[$log['id']].' IP: '.$log['ip'];
    if (array_key_exists($log['id'], $clickCountingAry)) {
      $clickCountingAry[$log['id']]['clickTimes']++;
    }
    else {
      $clickCountingAry[$log['id']]['name'] = $resourceIdArray[$log['id']];
      $clickCountingAry[$log['id']]['clickTimes'] = 1;
    }
  }

  print_r($clickCountingAry);

?>
