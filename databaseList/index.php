<?php
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');

  echo file_get_contents('./eResourceList.json');
  // $decodeJsonData = json_decode($getJsonData, true);
?>