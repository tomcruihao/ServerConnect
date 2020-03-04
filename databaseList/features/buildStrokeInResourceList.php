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

  // 1st foreach loop languages
  foreach($resourceList as $key_lang => $language) {
    foreach($language as $key_r => $row) {
      // get first char
      $chars = preg_split('/(?<!^)(?!$)/u', $row['resourceName']);
      $firstChar = $chars[0];
      $resultExist = false;

      foreach($strokes as $stroke) {
        if(strcasecmp($firstChar, $stroke['char']) == 0) {
          $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
          $firstZhuyin = $zhuyin[0];
          $resourceList['rows'][$key]['zhuyin'] = $firstZhuyin;
          $resourceList['rows'][$key]['englishAlphabet'] = '';

          if(strlen(strval($stroke['strokes'])) < 2) {
            $resourceList['rows'][$key]['strokes'] = '0'.$stroke['strokes'];
          } else {
            $resourceList['rows'][$key]['strokes'] = $stroke['strokes'];
          }

          $resultExist = true;
          break;
        }
      }

      if(!$resultExist) {
        $resourceList['rows'][$key_lang][$key_r]['englishAlphabet'] = $firstChar;
        $resourceList['rows'][$key_lang][$key_r]['zhuyin'] = '';
        $resourceList['rows'][$key_lang][$key_r]['strokes'] = '0';
      }
    }
  }
  print_r($resourceList);
  // foreach($resourceList['rows'] as $key => $row) {
  //   // get first char
  //   $chars = preg_split('/(?<!^)(?!$)/u', $row['resourceName']);
  //   $firstChar = $chars[0];
  //   $resultExist = false;

  //   foreach($strokes as $stroke) {
  //     if(strcasecmp($firstChar, $stroke['char']) == 0) {
  //       $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
  //       $firstZhuyin = $zhuyin[0];
  //       $resourceList['rows'][$key]['zhuyin'] = $firstZhuyin;
  //       $resourceList['rows'][$key]['englishAlphabet'] = '';

  //       if(strlen(strval($stroke['strokes'])) < 2) {
  //         $resourceList['rows'][$key]['strokes'] = '0'.$stroke['strokes'];
  //       } else {
  //         $resourceList['rows'][$key]['strokes'] = $stroke['strokes'];
  //       }

  //       $resultExist = true;
  //       break;
  //     }
  //   }

  //   if(!$resultExist) {
  //     $resourceList['rows'][$key]['englishAlphabet'] = $firstChar;
  //     $resourceList['rows'][$key]['zhuyin'] = '';
  //     $resourceList['rows'][$key]['strokes'] = '0';
  //   }

  //   // $newChar = iconv(mb_detect_encoding($firstChar), "big5", $firstChar);

  //   // echo $newChar;
  // }
  // // write back
  // file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  // $res = array('type' => 'success', 'mesage' => 'success');
  // echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
