<?php
  header("Content-Type:text/html;charset=utf-8");

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents('../data/eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  // get strokes list
  $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
  $strokes = json_decode($getStrokesJsonData, true);

  // foreach($strokes as $key => $row) {
  //   $firstChar = $row['char'];
  //   echo mb_detect_encoding($firstChar);
  // }

  foreach($resourceList['rows'] as $key => $row) {
    // get first char
    $chars = preg_split('/(?<!^)(?!$)/u', $row['resourceName']);
    $firstChar = $chars[0];
    $resultExist = false;

    foreach($strokes as $stroke) {
      if(strcasecmp($firstChar, $stroke['char']) == 0) {
        // print_r($resourceList['rows'][$key]);
        // echo $stroke['char'];
        // echo $stroke['strokes'];
        // echo '<br>';

        $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
        $firstZhuyin = $zhuyin[0];
        $resourceList['rows'][$key]['zhuyin'] = $firstZhuyin;

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
      $resourceList['rows'][$key]['zhuyin'] = '';
      $resourceList['rows'][$key]['strokes'] = '0';
    }

    // $newChar = iconv(mb_detect_encoding($firstChar), "big5", $firstChar);

    // echo $newChar;
  }
  // write back
  file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  echo 'execute success!';
?>
