<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $temp_en = [];
  $temp_tw = [];

  foreach($resourceList as $key => $value) {
    $temp_common = [];
    foreach($resourceList as $key => $value) {
      echo $value;
      if(!(strcasecmp($key, 'en') == 0) || !(strcasecmp($key, 'tw') == 0)) {
        array_push($temp_common, $value);
      }
    }

    print_r($temp_common);
    // $resourceList['en']
  }

  // echo $getJsonData;
?>
