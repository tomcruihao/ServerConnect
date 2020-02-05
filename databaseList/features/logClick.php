<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  date_default_timezone_set('Asia/Taipei');

  $getLogData = file_get_contents('../data/logUserCountClick.json');
  $logData = json_decode($getLogData, true);

  // $receivedData = json_decode($_POST["directionData"], true);

  $log = [];
  $log['clickedDateTime'] = date("Y-m-d h:i:s");
  $log['ip'] = getUserIpAddr();

  array_push($logData, $log);
  // write back
  file_put_contents('../data/logUserCountClick.json', json_encode($logData, JSON_UNESCAPED_UNICODE));
  response('success', 'success');

  function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
      //ip from share internet
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      //ip pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
?>