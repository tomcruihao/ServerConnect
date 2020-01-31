<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $type = $_POST["type"];
  $newResource = $_POST["resource"];
  echo $newResource;

  $getJsonData = file_get_contents('../eResourceList.json');
  $resourceInfo = json_decode($getJsonData, true);

  // get the latest ID
  $latestResource = end($resourceInfo['rows']);
  $newItemID = strval($latestResource['id']) + 1;




  // update resource info and write back
  $total = count($resourceInfo);

  // // create an obj and attend to original json
  // $aryLength = count($decodeJsonData);
  // $newItem = array('id' => strval($sid),'appKey' => strval($appKey), 'appID' => strval($appID), 'connectingUrl' => strval($connectUrl));
  // array_push($decodeJsonData, $newItem);

  // // rewrite the file
  // file_put_contents('./univ.json', json_encode($decodeJsonData, JSON_NUMERIC_CHECK));

  // // return result
  // $data = array('result' => true, 'msg' => 'success');
  // echo json_encode($data, JSON_NUMERIC_CHECK);
?>
