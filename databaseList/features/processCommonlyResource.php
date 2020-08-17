<?php
  include '_header.php';
  include 'verifyToken.php';

  $jsonFile_direct = '../data/commonlyResource.json';

  // parameters
  $resource = $_POST["resourceList"];

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $resourceList = $resource;

  // write back
  file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
