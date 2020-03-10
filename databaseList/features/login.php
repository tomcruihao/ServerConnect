<?php
  foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
  }
　session_start();
  $_SESSION['UserName']='Jordan';
  echo $_SESSION['UserName'];
?>