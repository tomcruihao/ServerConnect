<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');

  $jsonFile_direct = '../data/u5er.json';

  $getUserListJsonData = file_get_contents($jsonFile_direct);
  $userList = json_decode($getUserListJsonData, true);

  $received_user = '';
  if(isset($_POST['user'])) {
    $received_user = json_decode($_POST["user"], true);
  }

  // encrypted the password
  $encryptedPwd = sha1(md5($received_user['account'].$received_user['password']));
  echo $encryptedPwd;

  $auth = false;
  foreach($userList as $row) {
    if(strcasecmp($row['account'], $received_user['account']) == 0) {
      echo 'account is true';
      if(strcasecmp($row['pwd'], $received_user['password']) == 0) {
        echo 'password is true';
        $auth = true;
      }
    }
  }
  echo $auth;
  // compare the pwd


  


  // foreach (getallheaders() as $name => $value) {
  //   echo "$name: $value\n";
  // }

  // // session_start();
  // // echo $_SESSION['UserName'];
  // if(isset($_SESSION['UserName'])) {
  //   echo 'session is exist';
  //   echo $_SESSION['UserName'];
  // } else {
  //   $_SESSION['UserName'] = 'Jordan';
  //   echo $_SESSION['UserName'];
  // }
?>
