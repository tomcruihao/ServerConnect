<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

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
?>
