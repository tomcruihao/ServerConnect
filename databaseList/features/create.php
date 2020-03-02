<?php
  ini_set("display_errors", 1);
  ini_set("track_errors", 1);
  ini_set("html_errors", 1);
  error_reporting(E_ALL);

  $jsonFile_direct = '../data/eResourceList.json';

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  // header("Content-Type:text/html;charset=utf-8");
  header('Content-Type: application/json');

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  foreach($resourceList['rows'] as $key => $row) {
    // clone ID and array
    $id = clone $resourceList['rows'][$key]['id'];
    $en = clone $resourceList['rows'][$key];
    $en = clone $resourceList['rows'][$key];

    // clear array
    $resourceList['rows'][$key] = array();
    $resourceList['rows'][$key]['id'] = $id;
    $resourceList['rows'][$key]['en'] = $en;
    $resourceList['rows'][$key]['tw'] = $en;
    print_r($resourceList['rows'][$key]);
  }
?>