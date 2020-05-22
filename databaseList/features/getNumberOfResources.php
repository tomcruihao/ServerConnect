<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $getResourceListJsonData = file_get_contents('../data/eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  $res = array('status' => 'success', 'number' => count($resourceList));
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>