<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  if(isset($_POST['user'])) {
    session_start();
    $received_user = json_decode($_POST["user"], true);

    $_SESSION['departmentID'] = $received_user['departmentID'];
    $_SESSION['identity'] = $received_user['identity'];

    $response = array('status' => 'success', 'type' => 'pass');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    $response = array('status' => 'error', 'type' => 'account');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
?>
