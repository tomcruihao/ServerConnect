<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);
  

  $getLogJsonData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogJsonData, true);

  $resourceIdArray = [];
  print_r($resourceData);
  echo '<br><br><br><br>';
  print_r($resourceData.rows);
  foreach($resourceData.rows as $value) {
    $resourceIdArray[$value.id] = $value.resourceName;
  }
  print_r($resourceIdArray);
?>
