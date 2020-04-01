<?php 
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  include('EDSapiFeatures/rest/EBSCOAPI.php');
  /*On initializarion
  * 
  * Check token.txt file exist or not
  * if not create a new file and call API Aithentication Method
  * write authToken and timestamp into token.txt file
  * 
  */
  $lockfile = fopen("lock.txt","w+");
  fclose($lockfile);
  if(file_exists("token.txt")) {

  } else {
    $tokenFile = fopen("token.txt","w+");
    $api = new EBSCOAPI();
    $result = $api->apiAuthenticationToken();
    fwrite($tokenFile, $result['authenticationToken']."\n");
    fwrite($tokenFile, $result['authenticationTimeout']."\n");
    fwrite($tokenFile, $result['authenticationTimeStamp']);
    fclose($tokenFile);
  }
?>