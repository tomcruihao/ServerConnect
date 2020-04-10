<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header('Content-Type: application/json;charset=UTF-8');

  $amountOfDatabases = 5;


  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);

  $getLogJsonData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogJsonData, true);


  // create map and countable database list
  $databaseList = [];
  foreach($resourceData as $resource) {
    $databaseList[$resource['uuid']] = array(
      "uuid" => $resource['uuid'],
      "name" => array(
        "en" => $resource['en']['resourceName'],
        "local" => $resource['local']['resourceName'],
      ),
      "resourceUrl" => $resource['resourceUrl'],
      "clickTimes" => 0,
    );
  }

  // // create log counting array
  foreach($logData['log'] as $log) {
    if($log['uuid'] !== null) {
      $databaseList[$log['uuid']]['clickTimes']++;
    }
  }

  // sort the array
  usort($databaseList, function($a, $b) {
    return $a['clickTimes'] - $b['clickTimes'];
  });

  // get result
  $result = array();
  $counter = 0;
  foreach(array_reverse($databaseList) as $database) {
    if($counter < $amountOfDatabases) {
      array_push($result, $database);
      $counter++;
    } else {
      break;
    }
  }

  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
