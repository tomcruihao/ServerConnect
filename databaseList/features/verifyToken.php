<?php
  session_start();

  if(isset($_SESSION['userAccount']) && isset($_SESSION['expiredTime'])) {
    $expiredTime = strtotime($_SESSION['expiredTime']);
    $string_now = date("Y-m-d H:i:s");
    $now = strtotime($string_now);
    $auth = checkAuth();

    if($now > $expiredTime) {
      $res = array('status' => 'expired', 'type' => 'expired', 'mesage' => 'expired');
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
      exit();
    } else if (!$auth) {
      $res = array('status' => 'expired', 'type' => 'expired', 'mesage' => 'expired');
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
      exit();
    }
  } else {
    $res = array('status' => 'expired', 'type' => 'Auth Failed', 'mesage' => 'Auth Failed');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    exit();
  }

  function checkAuth() {
    $result = false;
    $getUserListJsonData = file_get_contents('../data/u5er.json');
    $userList = json_decode($getUserListJsonData, true);

    foreach($userList as $row) {
      if(strcasecmp($row['account'], $_SESSION['userAccount']) == 0) {
        $result = true;
      }
    }
    return $result;
  }
?>
