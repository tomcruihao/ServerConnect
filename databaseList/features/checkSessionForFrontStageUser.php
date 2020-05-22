<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');

  session_start();

  if(isset($_SESSION['hotNews'])) {
    $res = array('status' => 'success', 'data' => 'seen');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  } else {
    $_SESSION['hotNews'] = true;
    $res = array('status' => 'success', 'data' => 'not yet');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
