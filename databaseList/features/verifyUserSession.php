<?php
  include '_header.php';

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
