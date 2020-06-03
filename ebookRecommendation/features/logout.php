<?php
  session_start();

  unset($_SESSION['userAccount']);
  unset($_SESSION['expiredTime']);

  $res = array('status' => 'success', 'type' => 'success', 'mesage' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
