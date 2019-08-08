<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');

  $appKey = $_POST['appKey'];
  $appID = $_POST['appID'];
  $connectUrl = $_POST['connectUrl'];
  $data = array('appKey' => $appKey, 'appID' => $appID, 'connectUrl' => $connectUrl), JSON_NUMERIC_CHECK;
  echo json_encode($data);
?>