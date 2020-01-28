<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');

  $getJsonData = file_get_contents('./eResourceList.json');
  echo $getJsonData;
  // $decodeJsonData = json_decode($getJsonData, true);
?>