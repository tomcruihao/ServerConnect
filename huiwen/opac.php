<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Shanghai');


  $jsonFilePath = './univ.json';

  $sid = $_GET['sid'];
  $marcNum = $_GET['marc'];

  $univInfo = getJson($jsonFilePath);

  // get Univ detail
  $appID = null;
  $appKey = null;
  $connectingUrl = null;

  foreach ($univInfo as $univ) {
    if(strcasecmp($univ['id'], $sid) == 0) {
      $appID = $univ['appID'];
      $appKey = $univ['appKey'];
      $connectingUrl = $univ['connectingUrl'];
      break;
    }
  }

  // generate url path
  $timestamp = getCurrentTime();
  $stringBinding = $marcNum.$timestamp.$appKey;

  $sign = strtolower(md5($stringBinding));
  

  echo $connectingUrl.'?marc_no='.$marcNum.'&appid='.$appID.'&time='.$timestamp.'&sign='.$sign;


  function getJson($path) {
    $getJsonData = file_get_contents($path);
    $decodeJsonData = json_decode($getJsonData, true);

    return $decodeJsonData;
  }

  function getCurrentTime() {
    $currentTime = time();
    return trim(date("Y-m-dH:i:s", $currentTime), ' ');
  }
?>