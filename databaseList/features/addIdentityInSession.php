<?php
  include '_header.php';

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
