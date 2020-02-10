<?php
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
    $firstChar = substr($row['resourceName'], 0, 1);

    if(mb_detect_encoding($firstChar) === 'UTF-8') {
      echo $firstChar;
    }
    // $newChar = iconv(mb_detect_encoding($firstChar), "big5", $firstChar);

    // echo $newChar;
  }
?>
