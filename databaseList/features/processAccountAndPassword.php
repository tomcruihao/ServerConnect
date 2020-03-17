<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  // include 'verifyToken.php';

  $jsonFile_direct = '../data/u5er.json';

  $getUserListJsonData = file_get_contents($jsonFile_direct);
  $userList = json_decode($getUserListJsonData, true);

  $received_user = '';
  if(isset($_POST['user'])) {
    $received_user = json_decode($_POST["user"], true);
  }

  // verify the old password


  // encrypted the password
  

  // compare the pwd
  foreach($userList as $row) {
    if(strcasecmp($row['account'], $received_user['account']) == 0) {
      if(strcasecmp($row['pwd'], $encryptedPwd) == 0) {
        
      } else {
        response('oldPasswrodWrong', 'oldPasswrodWrong');
        exit();
      }
    }
  }

  function generatePassword($account, $password) {
    return sha1(md5($account.$password));
  }

  function response($status, $message, $data) {
    if($status === 'success') {
      $res = array('status' => $errorType, 'data' => $data);
    }
    $res = array('status' => $errorType, 'type' => $message);

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
