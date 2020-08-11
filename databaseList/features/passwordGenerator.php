<?php
  include '_header.php';

  $received_user = '';
  if(isset($_POST['user'])) {
    $received_user = json_decode($_POST["user"], true);
    $encryptedPwd = sha1(md5($received_user['account'].$received_user['password']));

    response('success', 'success', $encryptedPwd);
  }

  function response($status, $message, $data) {
    if($status === 'success') {
      $res = array('status' => $message, 'data' => $data);
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
