<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');

  $sid = $_POST['sid'];
  $appKey = $_POST['appKey'];
  $appID = $_POST['appID'];
  $connectUrl = $_POST['connectUrl'];

  $getJsonData = file_get_contents('./univ.json');
  $decodeJsonData = json_decode($getJsonData, true);

  $checkExist = false;

  foreach ($getJsonData as $univ) {
    if(strcasecmp($univ['id'], $sid) == 0) {
      $checkExist = true;
      break;
    }
  }

  if(!$checkExist) {
    $newItem = array('id' => strval($sid),'appKey' => strval($appKey), 'appID' => strval($appID), 'connectUrl' => strval($connectUrl));
    array_push($decodeJsonData, $newItem);
    echo json_encode($decodeJsonData, JSON_NUMERIC_CHECK);
  }
?>