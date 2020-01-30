<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $sid = $_POST['sid'];

  $getJsonData = file_get_contents('../eResourceList.json');
  $decodeJsonData = json_decode($getJsonData, true);

  // get the latest item ID
  $latstResource = end($decodeJsonData['rows']);
  print_r($latstResource);

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
