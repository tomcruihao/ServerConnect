<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  // header('Content-Type: application/json');
  header("Content-Type:text/html;charset=utf-8");

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $temp_en = [];
  $temp_tw = [];

  foreach($resourceList as $key => $value) {
    $temp_common = [];
    foreach($value as $vkey => $vValue) {
      // get position of language
      echo $vkey;
      // $i_en = array_search('en', array_keys($value));
      // $i_tw = array_search('tw', array_keys($value));

      // if(!(strcasecmp($i_en, $key) == 0) || !(strcasecmp($i_en, $key) == 0)) {
      //   array_push($temp_common, $value);
      // }
    }

    // print_r($temp_common);
    // $resourceList['en']
  }

  // echo $getJsonData;
?>
