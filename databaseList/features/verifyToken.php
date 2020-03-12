<?php
// ini_set("display_errors", 1);
// ini_set("track_errors", 1);
// ini_set("html_errors", 1);
// error_reporting(E_ALL);
  session_start();

  if(isset($_SESSION['userAccount'])) {
    
  } else {
    $res = array('status' => 'error', 'type' => 'Auth Failed', 'mesage' => 'Auth Failed');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    exit();
  }
?>
