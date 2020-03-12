<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  include 'verifyToken.php';

  $jsonFile_direct = '../data/settings.json';

  // parameters
  $recievedSettings = json_decode($_POST["settings"], true);

  // get resource list
  $getSettingJsonData = file_get_contents($jsonFile_direct);
  $settings = json_decode($getSettingJsonData, true);

  // replace the settings
  $settings = $recievedSettings;

  // write the setting back to the file
  file_put_contents($jsonFile_direct, json_encode($settings, JSON_UNESCAPED_UNICODE));
  response('success', 'success');

  function response($errorType, $message) {
    $res = array('type' => $errorType, 'mesage' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
