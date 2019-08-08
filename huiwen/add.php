<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');

  $appKey = $_POST['appKey'];
  $appID = $_POST['appID'];
  $connectUrl = $_POST['connectUrl'];
  $data = array('appKey' => $appKey, 'appID' => $appID, 'connectUrl' => $connectUrl);
  echo json_encode($data, JSON_NUMERIC_CHECK);
?>