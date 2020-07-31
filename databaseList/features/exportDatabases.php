<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  include 'verifyToken.php';

  $jsonFile_direct = '../data/eResourceList.json';
  $fileDir = '../csvFiles/exportResources.txt';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $resourceListLength = count($resourceList);

  $tempList = getMataData($resourceList[0]);

  foreach($resourceList as $rkey => $resource) {
    foreach($resource as $key => $value) {
      if(!(strcasecmp('local', $key) == 0) && !(strcasecmp('en', $key) == 0) && !(strcasecmp('tw', $key) == 0)) {
        array_push($tempList[$key], $value);
      } else if((strcasecmp('local', $key) == 0) || (strcasecmp('en', $key) == 0)) {
        foreach($value as $vkey => $vValue) {
          array_push($tempList[$key.'__'.$vkey], $vValue);
        }
      }
    }
  }

  // write the result in the file
  $content = '';
  $metaCounter = 0;
  foreach($tempList as $tkey => $tValue) {
    if($metaCounter == 0) {
      $content = $tkey;
    } else {
      $content = $content."\t".$tkey;
    }
    $metaCounter++;
  }
  $content = $content."\n";

  for ($index = 0; $index < $resourceListLength ; $index++ ) {
    $tempCounter = 0;
    foreach($tempList as $tkey => $tValue) {
      if($tempCounter == 0) {
        $content = $content."\"".preg_replace("/\r|\n/", "", $tempList[$tkey][$index])."\"";
      } else {
        $content = $content."\t"."\"".preg_replace("/\r|\n/", "", $tempList[$tkey][$index])."\"";
      }
      $tempCounter++;
    }
    $content = $content."\n";
  }
  $content = mb_convert_encoding($content, 'UTF-8', "auto");
  file_put_contents($fileDir, $content);

  // download the file
  if (file_exists($fileDir)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fileDir).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileDir));
    readfile($fileDir);
    exit;
    echo "<script>window.close();</script>";
  }

  function getMataData($resource) {
    $result = array();
    foreach($resource as $key => $value) {
      if(!(strcasecmp('local', $key) == 0) && !(strcasecmp('en', $key) == 0) && !(strcasecmp('tw', $key) == 0)) {
        $result[$key] = array();
      } else if((strcasecmp('local', $key) == 0) || (strcasecmp('en', $key) == 0)) {
        foreach($value as $vkey => $vValue) {
          $result[$key.'__'.$vkey] = array();
        }
      }
    }

    return $result;
  }
?>
