<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Taipei');


  $jsonFilePath = './univ.json';

  $sid = $_GET['sid'];
  $marcNum = $_GET['marc'];

  $univInfo = getJson($jsonFilePath);

  // get Univ detail
  $connectingUrl = null;

  foreach ($univInfo as $univ) {
    if(strcasecmp($univ['id'], $sid) == 0) {
      $connectingUrl = $univ['connectingUrl'];
      break;
    }
  }

  // generate url path
  $stringBinding = $marcNum.$timestamp.$appKey;

  echo $connectingUrl.'?marc_no='.$marcNum;

  function getJson($path) {
    $getJsonData = file_get_contents($path);
    $decodeJsonData = json_decode($getJsonData, true);

    return $decodeJsonData;
  }
?>