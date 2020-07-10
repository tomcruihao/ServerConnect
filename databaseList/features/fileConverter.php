<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  // received the csv data and move to csv folder
  // http://gss.ebscohost.com/chchang/ServerConnect/databaseList/csvFiles/exportResources.txt
  $jsonFile_direct = '../data/eResourceList.json';
  // $txtFilePath = "../csvFiles/exportResources.txt";
  $txtFilePath = receivedFileAndGetPath();

  // get data from file
  $fileData = file_get_contents($txtFilePath);
  $rows = explode("\n", $fileData);
  $resourceKeys = explode("\t", $rows[0]);

  // remove metadata from resources
  unset($rows[0]);

  // create an array to store the databases
  $resourceList = [];

  foreach($rows as $row_key => $row_val) {
    $array_temp = [];
    $resourceContent = explode("\t", $rows[$row_key]);

    foreach($resourceContent as $index => $resourceContent_val) {
      $array_temp[$resourceKeys[$index]] = str_replace('"', '', $resourceContent_val);
    }

    array_push($resourceList, $array_temp);
  }

  foreach($resourceList as $key_resource => $resource) {
    // gen UUID

    // if (array_key_exists('uuid', $resourceList[$key_resource])) {
    //   if(empty($resourceList[$key_resource]['uuid'])) {
    //     $resourceList[$key_resource]['uuid'] = gen_uuid();
    //   }
    // } else {
    //   $resourceList[$key_resource]['uuid'] = gen_uuid();
    // }
    // if(strcmp($resourceList[$key_resource]['isProxy'], "是") === 0) {
    //   $resourceList[$key_resource]['isProxy'] = true;
    // } else if(strcmp($resourceList[$key_resource]['isProxy'], "否") === 0) {
    //   $resourceList[$key_resource]['isProxy'] = false;
    // }

    // find all language
    $tempAry = [];
    foreach($resource as $key_r => $row) {
      if (strpos($key_r, '__')) {
        $array_language = explode("__",$key_r);
        $tempAry[$array_language[0]][$array_language[1]] = $row;
        unset($resourceList[$key_resource][$key_r]);
      }
    }

    foreach($tempAry as $t_key => $t_row) {
      $resourceList[$key_resource][$t_key] = $t_row;
    }
  }

  // write back
  // echo json_encode($resourceList, JSON_UNESCAPED_UNICODE);
  file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);

  function receivedFileAndGetPath() {
    if ( 0 < $_FILES['file']['error'] ) {
      return false;
    } else {
      move_uploaded_file($_FILES['file']['tmp_name'], '../csvFiles/' . $_FILES['file']['name']);
      return '../csvFiles/'.$_FILES['file']['name'];
    }
  }
?>
