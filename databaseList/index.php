<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json; charset=utf-8');

  echo file_get_contents('./eResourceList.json');
  // $decodeJsonData = json_decode($getJsonData, true);
?>