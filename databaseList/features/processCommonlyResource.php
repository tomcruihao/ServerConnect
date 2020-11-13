<?php
  include '_header.php';
  include 'verifyToken.php';
  include '_response.php';

  $jsonFile_direct = '../data/commonlyResource.json';

  // parameters
  $type = $_POST["type"];
  $resourceList = '';
  $enableFeature = '';

  if(isset($_POST["enableFeature"])) {
    $enableFeature = $_POST["enableFeature"];
  }
  if(isset($_POST["resourceList"])) {
    $resourceList = $_POST["resourceList"];
  }

  // get resource list
  $getResourceInfoJsonData = file_get_contents($jsonFile_direct);
  $resourceInfo = json_decode($getResourceInfoJsonData, true);

  if($type === 'enableFeature') {
    $resourceInfo["enabled"] = $enableFeature;
  } else if($type === 'updateResource') {
    $resourceInfo["resources"] = $resourceList;
  }

  // write back
  if(is_writable($jsonFile_direct)) {
    file_put_contents($jsonFile_direct, json_encode($resourceInfo, JSON_UNESCAPED_UNICODE));
    $res = array('status' => 'success', 'type' => 'success');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  } else {
    responseError(1001);
  }
?>
