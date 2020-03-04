<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $jsonFile_direct = '../data/strokeList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents('../data/eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  $allZhuYin = 'ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄧㄨㄩㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦ';
  $allEnglishAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $zhuYins = preg_split('/(?<!^)(?!$)/u', $allZhuYin);
  $englishAlphabets = str_split($allEnglishAlphabet);
  $zhuyin_map = [];
  $englishAlphabet_map = [];
  $strokes_map = [];

  // init map
  foreach($zhuYins as $key => $row) {
    $zhuyin_map[$row] = false;
  }

  foreach($englishAlphabets as $key => $row) {
    $englishAlphabet_map[$row] = false;
  }

  for($loop = 1; $loop < 50; $loop++) {
    if($loop < 10) {
      $strokes_map['0'.strval($loop)] = false;
    } else {
      $strokes_map[strval($loop)] = false;
    }
  }

  // $strokes_map = array_fill(1,70, false);

  // match with the map
  foreach($resourceList as $key_lang => $language) {
    foreach($language as $key => $row) {
      if($row['zhuyin'] !== '') {
        $zhuyin_map[$row['zhuyin']] = true;
      } else if(preg_match("/^[a-zA-Z]$/", $row['englishAlphabet'])) {
        $char_uppercase = strtoupper($row['englishAlphabet']);
        $englishAlphabet_map[$char_uppercase] = true;
      }
      if($row['strokes'] !== '0') {
        $strokes_map[$row['strokes']] = true;
      }
    }
  }

  // create the list
  $result = [];
  $result['zhuyin'] = [];
  $result['englishAlphabet'] = [];
  $result['strokes'] = [];

  foreach($zhuyin_map as $key => $row) {
    if($row) {
      array_push($result['zhuyin'], $key);
    }
  }

  foreach($englishAlphabet_map as $key => $row) {
    if($row) {
      array_push($result['englishAlphabet'], $key);
    }
  }

  foreach($strokes_map as $key => $row) {
    if($row) {
      array_push($result['strokes'], $key);
    }
  }
  
  // write back
  file_put_contents($jsonFile_direct, json_encode($result, JSON_UNESCAPED_UNICODE));
  $res = array('type' => 'success', 'mesage' => 'success');
  echo $res;
?>
