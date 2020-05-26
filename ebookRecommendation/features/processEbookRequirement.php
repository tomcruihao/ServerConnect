<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  // include 'verifyToken.php';

  $jsonFile_direct = '../data/ebookRequirementList.json';

  // parameters
  $type = $_POST["type"];

  if(isset($_POST['formData'])) {
    $formData = json_decode($_POST["formData"], true);
  }
  if(isset($_POST['list'])) {
    $ebookList = json_decode($_POST["list"], true);
  }
  
  // get resource list
  $JSON_requirementListData = file_get_contents($jsonFile_direct);

  if(is_null($JSON_requirementListData)) {
    $requirementList = array();
  } else {
    $requirementList = json_decode($JSON_requirementListData, true);
  }


  if ($type === 'add') {
    // // gen the uuid
    $formData['uuid'] = gen_uuid();
    $formData['applyDateTime'] = date("Y-m-d h:i:s");

    array_push($requirementList, $formData);

    // write back
    file_put_contents($jsonFile_direct, json_encode($requirementList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if ($type === 'delete') {
    foreach($ebookList as $key => $row) {
      foreach($requirementList as $r_key => $r_row) {
        if(strcasecmp($row, $r_row['uuid']) == 0) {
          // unset($resourceList['rows'][$key]);
          array_splice($requirementList, $r_key, 1);
          break;
        }
      }
    }

    // write back
    file_put_contents($jsonFile_direct, json_encode($requirementList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  }

  // uuid V4
  function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }

  function response($errorType, $message) {
    $res = array('status' => $errorType, 'type' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
