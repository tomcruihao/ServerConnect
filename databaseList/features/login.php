<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');


  echo "ehllo";
  // foreach (getallheaders() as $name => $value) {
  //   echo "$name: $value\n";
  // }
// 　session_start();
//   $_SESSION['UserName']='Jordan';
//   echo $_SESSION['UserName'];
?>