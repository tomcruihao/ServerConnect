<?php
// ini_set("display_errors", 1);
// ini_set("track_errors", 1);
// ini_set("html_errors", 1);
// error_reporting(E_ALL);
  session_start();

  if(isset($_SESSION['userAccount']) && isset($_SESSION['expiredTime'])) {
    $expiredTime = strtotime($_SESSION['expiredTime']);
    $string_now = date("Y-m-d H:i:s");
    $now = strtotime($string_now);

    if($now > $expiredTime) {
      $res = array('status' => 'expired', 'type' => 'Expired', 'mesage' => 'Expired');
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
      exit();
    }
  } else {
    $res = array('status' => 'expired', 'type' => 'Auth Failed', 'mesage' => 'Auth Failed');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    exit();
  }
?>
