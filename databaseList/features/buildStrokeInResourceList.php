<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
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
  file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
