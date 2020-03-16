<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  // header("Content-Type:text/html;charset=utf-8");

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  // get Proxy
  $getSettingJsonData = file_get_contents('../data/settings.json');
  $settingData = json_decode($getSettingJsonData, true);

  $proxy = $settingData['proxy'];

  $result = [];
  $result_en = [];
  $result_tw = [];

  foreach($resourceList as $key => $value) {
    $temp_tw = [];
    $temp_en = [];
    $isProxy = false;

    foreach($value as $vkey => $vValue) {
      // get position of language
      // $i_en = array_search('en', array_keys($value));

      if(!(strcasecmp('local', $vkey) == 0) && !(strcasecmp('en', $vkey) == 0)) {
        $temp_tw[$vkey] = $vValue;
        $temp_en[$vkey] = $vValue;
      }

      if(strcasecmp('isProxy', $vkey) == 0) {
        $isProxy = filter_var($vValue, FILTER_VALIDATE_BOOLEAN);
      }
    }

    // get en value and write
    foreach($value['en'] as $ekey => $eValue) {
      $temp_en[$ekey] = $eValue;
    }

    foreach($value['local'] as $tkey => $tValue) {
      $temp_tw[$tkey] = $tValue;
    }

    if($isProxy) {
      $temp_en['resourceUrl'] = $proxy.$temp_en['resourceUrl'];
      $temp_tw['resourceUrl'] = $proxy.$temp_local['resourceUrl'];
    }

    array_push($result_en, $temp_en);
    array_push($result_local, $temp_tw);
    // $resourceList['en']
  }
  $result['en'] = $result_en;
  $result['local'] = $result_tw;
  
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
