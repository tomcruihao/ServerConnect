<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);
// set_error_handler("var_dump");

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  // header("Content-Type:text/html;charset=utf-8");
  header('Content-Type: application/json');


  // parameters
  $type = $_POST["type"];
  // $resource = $_POST["resource"];
  $resource = json_decode($_POST["resource"], true);

  // get resource list
  $getResourceListJsonData = file_get_contents('../eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  if ($type === 'add') {
    // get the latest ID and add in resource list
    $latestResource = end($resourceList['rows']);
    $newItemID = strval($latestResource['id']) + 1;
    $resource['id'] = $newItemID;
    array_push($resourceList['rows'], $resource);

    // update resource info and write back
    $total = count($resourceList['rows']);
    $resourceList['total'] = $total;
    $resourceList['totalNotFiltered'] = $total;

    // echo json_encode($resource, JSON_NUMERIC_CHECK);
    echo json_encode($resourceList, JSON_UNESCAPED_UNICODE);
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
