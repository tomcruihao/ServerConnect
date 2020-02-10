<?php
  // get resource list
  $getResourceListJsonData = file_get_contents('../eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  // get strokes list
  $getStrokesJsonData = file_get_contents('../UniHanO.json');
  $strokes = json_decode($getStrokesJsonData, true);

  print_r($strokes);
?>
