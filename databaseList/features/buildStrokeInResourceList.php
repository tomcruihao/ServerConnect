<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $jsonFile_resource_direct = '../data/eResourceList.json';
  $jsonFile_strokes_direct = '../data/strokeList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_resource_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  // get strokes list
  $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
  $strokes = json_decode($getStrokesJsonData, true);

  // foreach($strokes as $key => $row) {
  //   $firstChar = $row['char'];
  //   echo mb_detect_encoding($firstChar);
  // }

  // for local
  foreach($resourceList as $key_lang => $resource) {
    $chars = preg_split('/(?<!^)(?!$)/u', $resource['local']['resourceName']);
    $firstChar = $chars[0];
    $resultExist = false;
    foreach($strokes as $stroke) {
      if(strcasecmp($firstChar, $stroke['char']) == 0) {
        $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
        $firstZhuyin = $zhuyin[0];
        $resourceList[$key_lang]['local']['zhuyin'] = $firstZhuyin;
        $resourceList[$key_lang]['local']['englishAlphabet'] = '';

        if(strlen(strval($stroke['strokes'])) < 2) {
          $resourceList[$key_lang]['local']['strokes'] = '0'.$stroke['strokes'];
        } else {
          $resourceList[$key_lang]['local']['strokes'] = $stroke['strokes'];
        }

        $resultExist = true;
        break;
      }

      if(!$resultExist) {
        $resourceList[$key_lang]['local']['englishAlphabet'] = $firstChar;
        $resourceList[$key_lang]['local']['zhuyin'] = '';
        $resourceList[$key_lang]['local']['strokes'] = '0';
      }
    }
  }

  // for en
  $alphas = array_merge(range('A', 'Z'), range('a', 'z'));
  foreach($resourceList as $key_lang => $resource) {
    $chars = preg_split('/(?<!^)(?!$)/u', $resource['en']['resourceName']);
    $firstChar = $chars[0];

    if(!in_array($firstChar, $alphas, TRUE)) {
      $firstChar = '';
    }
    // $firstChar = $chars[0];
    $resourceList[$key_lang]['en']['englishAlphabet'] = $firstChar;
    $resourceList[$key_lang]['en']['zhuyin'] = '';
    $resourceList[$key_lang]['en']['strokes'] = '0';
  }

  // write back
  file_put_contents($jsonFile_resource_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  // sleep 3sec
  sleep(3);

  ////////////////////////////// generate the alphabet list ///////////////////////////////////////

  // get resource list
  $getNewResourceListJsonData = file_get_contents($jsonFile_resource_direct);
  $newResourceList = json_decode($getNewResourceListJsonData, true);

  $allZhuYin = 'ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄧㄨㄩㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦ';
  $allEnglishAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $zhuYins = preg_split('/(?<!^)(?!$)/u', $allZhuYin);
  $englishAlphabets = str_split($allEnglishAlphabet);
  $zhuyin_map = [];
  $englishAlphabet_en_map = [];
  $englishAlphabet_local_map = [];
  $strokes_map = [];

  // init map
  foreach($zhuYins as $key => $row) {
    $zhuyin_map[$row] = false;
  }

  foreach($englishAlphabets as $key => $row) {
    $englishAlphabet_en_map[$row] = false;
    $englishAlphabet_local_map[$row] = false;
  }

  for($loop = 1; $loop < 50; $loop++) {
    if($loop < 10) {
      $strokes_map['0'.strval($loop)] = false;
    } else {
      $strokes_map[strval($loop)] = false;
    }
  }

  // $strokes_map = array_fill(1,70, false);

  // match with the local map
  foreach($newResourceList as $key_lang => $row) {
    if(!empty(trim($row['local']['zhuyin']))) {
      $zhuyin_map[$row['local']['zhuyin']] = true;
    }

    if(preg_match("/^[a-zA-Z]$/", $row['local']['englishAlphabet'])) {
      $char_uppercase = strtoupper($row['local']['englishAlphabet']);
      $englishAlphabet_local_map[$char_uppercase] = true;
    }

    if($row['local']['strokes'] !== '0') {
      $strokes_map[$row['local']['strokes']] = true;
    }
  }

  // match with the en map
  foreach($newResourceList as $key_lang => $row) {
    if(preg_match("/^[a-zA-Z]$/", $row['en']['englishAlphabet'])) {
      $char_uppercase = strtoupper($row['en']['englishAlphabet']);
      $englishAlphabet_en_map[$char_uppercase] = true;
    }
  }

  // create the list
  $result = [];
  $result['local']['zhuyin'] = [];
  $result['local']['englishAlphabet'] = [];
  $result['local']['strokes'] = [];
  $result['en']['englishAlphabet'] = [];

  foreach($zhuyin_map as $key => $row) {
    if($row) {
      array_push($result['local']['zhuyin'], $key);
    }
  }

  foreach($englishAlphabet_local_map as $key => $row) {
    if($row) {
      array_push($result['local']['englishAlphabet'], $key);
    }
  }

  foreach($strokes_map as $key => $row) {
    if($row) {
      array_push($result['local']['strokes'], $key);
    }
  }

  foreach($englishAlphabet_en_map as $key => $row) {
    if($row) {
      array_push($result['en']['englishAlphabet'], $key);
    }
  }
  
  // write back
  file_put_contents($jsonFile_strokes_direct, json_encode($result, JSON_UNESCAPED_UNICODE));
  // $res = array('status' => 'success', 'type' => 'success');
  // echo json_encode($res, JSON_UNESCAPED_UNICODE);
  
  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
