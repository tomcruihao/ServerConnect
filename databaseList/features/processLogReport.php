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
    $resourceIdArray["'".$resource['id']."'"] = $resource['resourceName'];
  }
  
  
  foreach($logData['log'] as $log) {
    echo $resourceData[$log['id']].' IP: '.$log['ip'];
    // $resourceIdArray[$resource['id']] = $resource['resourceName'];
  }
?>
