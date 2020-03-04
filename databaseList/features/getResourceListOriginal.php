<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  // header("Content-Type:text/html;charset=utf-8");

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $result = [];
  $result_en = [];
  $result_tw = [];

  foreach($resourceList as $key => $value) {
    $temp_tw = [];
    $temp_en = [];
    foreach($value as $vkey => $vValue) {
      // get position of language
      // $i_en = array_search('en', array_keys($value));

      if(!(strcasecmp('tw', $vkey) == 0) && !(strcasecmp('en', $vkey) == 0)) {
        $temp_tw[$vkey] = $vValue;
        $temp_en[$vkey] = $vValue;
      }
    }

    // get en value and write
    foreach($value['en'] as $ekey => $eValue) {
      $temp_en[$ekey] = $eValue;
    }

    foreach($value['tw'] as $tkey => $tValue) {
      $temp_tw[$tkey] = $tValue;
    }
    array_push($result_en, $temp_en);
    array_push($result_tw, $temp_tw);
    // $resourceList['en']
  }
  $result['en'] = $result_en;
  $result['tw'] = $result_tw;
  print_r($result);
?>
