<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  // header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  $getJsonData = file_get_contents('../data/authList.json');
  $authListData = json_decode($getJsonData, true);
  
  if($authListData['settings']['featureEnabled']) {
    session_start();

    if(isset($_SESSION['departmentID']) && isset($_SESSION['identity'])) {
      $res = array('status' => 'success', 'type' => 'pass');
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
    } else {
      $res = array('status' => 'expired', 'type' => 'expired');
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
  } else {
    $res = array('status' => 'success', 'type' => 'pass');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
