<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
  header('Content-Type: application/json; charset=utf-8');


  echo "{'test':'1234'}";
  // echo file_get_contents('eResourceList.json');
  // $decodeJsonData = json_decode($getJsonData, true);
?>