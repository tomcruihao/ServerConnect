<?php
  include '_header.php';

  include 'verifyToken.php';

  $jsonFile_direct = '../data/u5er.json';

  $getUserListJsonData = file_get_contents($jsonFile_direct);
  $userList = json_decode($getUserListJsonData, true);

  $received_user = '';
  if(isset($_POST['user'])) {
    $received_user = json_decode($_POST["user"], true);
  }

  $oldPassword = generatePassword($received_user['oldAccount'], $received_user['oldPassword']);

  // verify the old password. If not matched, exit
  foreach($userList as $key => $row) {
    if(strcasecmp($row['account'], $received_user['oldAccount']) == 0) {
      if(strcasecmp($row['pwd'], $oldPassword) == 0) {
        $newPassword = generatePassword($received_user['newAccount'], $received_user['newPassword']);

        $userList[$key]["account"] = $received_user['newAccount'];
        $userList[$key]["pwd"] = $newPassword;

        // write back
        file_put_contents($jsonFile_direct, json_encode($userList, JSON_UNESCAPED_UNICODE));
        response('success', 'success');
        break;
      } else {
        response('old_password_wrong', 'old_password_wrong');
        exit();
      }
    }
  }

  function generatePassword($account, $password) {
    return sha1(md5($account.$password));
  }

  function response($status, $message, $data) {
    $res = array('status' => $status, 'type' => $message);

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
