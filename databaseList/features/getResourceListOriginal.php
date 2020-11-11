<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $number = 0;
  if(isset($_GET['number'])) {
    $number = (int)$_GET['number'];
  }

  $getJsonData = file_get_contents('../data/eResourceList.json');

  if($number != 0) {
    // resource list
    $resourceData = json_decode($getJsonData, true);
    $tempAry = [];

    for($loop = 0 ; $loop < $number ; $loop++) {
      if($resourceData[$loop] == null) {
        break;
      }
      array_push($tempAry, $resourceData[$loop]);
    }

    echo json_encode($tempAry, JSON_UNESCAPED_UNICODE);
  } else {
    echo $getJsonData;
  }  
?>