<?php
  header("Content-Type:text/html;charset=utf-8");

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
    $result = '';

    foreach($strokes as $stroke) {
      if(strcasecmp($firstChar, $stroke['char']) == 0) {
        print_r($stroke);
        break;
      }
    }

    // $newChar = iconv(mb_detect_encoding($firstChar), "big5", $firstChar);

    // echo $newChar;
  }
?>
