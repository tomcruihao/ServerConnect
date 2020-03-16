<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $getSettingJsonData = file_get_contents('../data/settings.json');
  $settingData = json_decode($getSettingJsonData, true);

  $proxy = $settingData['proxy'];

  $result = [];
  $result['proxy'] = $proxy;

  $res = array('status' => $errorType, 'data' => $result);
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
