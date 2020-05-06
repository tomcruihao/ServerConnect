<?php
  session_start();

  if(isset($_SESSION['hotNews'])) {
    $res = array('status' => 'success', 'type' => 'seen');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  } else {
    $_SESSION['hotNews'] = true;
    $res = array('status' => 'success', 'type' => 'not yet');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
