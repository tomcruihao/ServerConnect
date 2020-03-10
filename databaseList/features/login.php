<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');


  foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
  }
// 　session_start();
//   $_SESSION['UserName']='Jordan';
//   echo $_SESSION['UserName'];
?>