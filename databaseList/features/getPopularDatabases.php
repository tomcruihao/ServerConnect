<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header('Content-Type: application/json;charset=UTF-8');

  // get setting list
  $jsonFile_direct = '../data/settings.json';
  $getSettingJsonData = file_get_contents($jsonFile_direct);
  $settings = json_decode($getSettingJsonData, true);

  $amountOfDatabases = $settings['numberOfPopularDatabases'];

  $getResourceData = file_get_contents('../data/eResourceList.json');
  $resourceData = json_decode($getResourceData, true);

  $getLogJsonData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogJsonData, true);


  // create map and countable database list
  $databaseList = [];
  foreach($resourceData as $resource) {
    $proxy = $resource['isProxy'] === $settingData['proxy'] ? $settings : '';

    $databaseList[$resource['uuid']] = array(
      "uuid" => $resource['uuid'],
      "name" => array(
        "en" => $resource['en']['resourceName'],
        "local" => $resource['local']['resourceName'],
      ),
      "resourceUrl" => $proxy.$resource['resourceUrl'],
      "clickTimes" => 0,
    );
  }

  // create log counting array
  foreach($logData['log'] as $log) {
    if($log['uuid'] !== null && array_key_exists($log['uuid'], $databaseList)) {
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
    if($counter < $amountOfDatabases && $database['clickTimes'] != 0) {
      array_push($result, $database);
      $counter++;
    } else {
      break;
    }
  }

  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
