<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $appKey = $_POST['appKey'];
  $appID = $_POST['appID'];
  $connectUrl = $_POST['connectUrl'];
  echo $appKey.' '.$appID.' '.$connectUrl;
?>