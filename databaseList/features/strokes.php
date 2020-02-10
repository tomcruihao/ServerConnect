<?php
  // get resource list
  $getResourceListJsonData = file_get_contents('../data/eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  // get strokes list
  $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
  $strokes = json_decode($getStrokesJsonData, true);

  foreach($resourceList['rows'] as $key => $row) {
    $firstChar = substr($row['resourceName'], 0, 1);
    $newChar = iconv(mb_detect_encoding($firstChar), "UTF-8", $firstChar);

    // if(strcasecmp($row['id'], $resource['id']) == 0) {
    //   $resourceList['rows'][$key] = $resource;
    //   break;
    // }
  }
?>
