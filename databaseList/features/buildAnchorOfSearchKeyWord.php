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
  foreach($resourceList as $key_lang => $row) {
    if(empty(trim($row['zhuyin']))) {
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
  foreach($resourceList as $key_lang => $row) {
    if(preg_match("/^[a-zA-Z]$/", $row['en']['englishAlphabet'])) {
      $char_uppercase = strtoupper($row['en']['englishAlphabet']);
      $englishAlphabet_en_map[$char_uppercase] = true;
    }
  }

  print_r($zhuyin_map);
  print_r($englishAlphabet_en_map);
  print_r($englishAlphabet_local_map);
  print_r($strokes_map);

  // create the list
  $result = [];
  $result['zhuyin'] = [];
  $result['englishAlphabet'] = [];
  $result['strokes'] = [];

  // foreach($zhuyin_map as $key => $row) {
  //   if($row) {
  //     array_push($result['zhuyin'], $key);
  //   }
  // }

  // foreach($englishAlphabet_map as $key => $row) {
  //   if($row) {
  //     array_push($result['englishAlphabet'], $key);
  //   }
  // }

  // foreach($strokes_map as $key => $row) {
  //   if($row) {
  //     array_push($result['strokes'], $key);
  //   }
  // }
  
  // write back
  // file_put_contents($jsonFile_direct, json_encode($result, JSON_UNESCAPED_UNICODE));
  // $res = array('type' => 'success', 'mesage' => 'success');
  // echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
