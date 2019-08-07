<?php

  $jsonFilePath = './test.json';
  $SID = $_GET['sid'];

  function main() {
    $getUnivInfo = getJson($jsonFilePath);
    
    // get Univ detail
    $appID = null;
    $appKey = null;
    $connectingUrl = null;

    foreach ($univInfo as $univ) {
      if(strcasecmp($univ['id'], $SID) == 0) {
        $appID = $univ['appID'];
        $appKey = $univ['appID'];
        $connectingUrl = $univ['appID'];
        break;
      }
    }
    echo 'AppID='.$appID.'</br>AppKey='.$appKey.'</br>ConnectingUrl='.$connectingUrl;
  }

  function getJson($path) {
    $getJsonData = file_get_contents($path);
    $decodeJsonData = json_decode($getJsonData, true);

    return $decodeJsonData;
  }

// function writeJsonFile() {
//   while($row=mysql_fetch_array($result)) { 
//     $title=$row['title']; 
//     $url=$row['url']; 

//     $posts[] = array('title'=> $title, 'url'=> $url);
//   } 

//   $response['posts'] = $posts;

//   $fp = fopen('results.json', 'w');
//   fwrite($fp, json_encode($response));
//   fclose($fp);  
// }
  main();
?>