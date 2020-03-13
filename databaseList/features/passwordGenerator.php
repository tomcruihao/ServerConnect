<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  $received_user = '';
  if(isset($_POST['user'])) {
    $received_user = json_decode($_POST["user"], true);
    $encryptedPwd = sha1(md5($received_user['account'].$received_user['password']));

    // echo $encryptedPwd;
    response('success', 'success', $encryptedPwd);
  }

  function response($status, $message, $data) {
    if($status === 'success') {
      $res = array('status' => $errorType, 'data' => $data);
    }
    $res = array('status' => $errorType, 'type' => $message);

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
