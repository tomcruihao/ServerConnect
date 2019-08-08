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
    // create an obj and attend to original json
    $newItem = array('id' => strval($sid),'appKey' => strval($appKey), 'appID' => strval($appID), 'connectUrl' => strval($connectUrl));
    array_push($decodeJsonData, $newItem);

    // rewrite the file
    file_put_contents('./univ.json', json_encode($decodeJsonData, JSON_NUMERIC_CHECK));

    // return result
    $data = array('result' => true, 'msg' => 'success');
    echo json_encode($data, JSON_NUMERIC_CHECK);
  }
?>