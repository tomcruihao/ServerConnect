<?php
  ini_set('display_errors','1');
  error_reporting(E_ALL);
  
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');


  // parameters
  $type = $_POST["type"];
  $resource = $_POST["resource"];
  // $resource = json_decode($_POST["resource"], true);

  // get resource list
  $getResourceListJsonData = file_get_contents('../eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  if ($type === 'add') {
    // get the latest ID
    $latestResource = end($resourceList['rows']);
    $newItemID = strval($latestResource['id']) + 1;
    // $resource['id'] = $newItemID

    // // update resource info and write back
    // $total = count($resourceList);

    // echo json_encode($resource, JSON_NUMERIC_CHECK);
  }
   // else if($type === 'modify') {
  //   echo 'modify';
  // }





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
