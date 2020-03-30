<?php
  function getRealurl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $html = curl_exec($ch);

    $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    return $redirectedUrl;


    // $curl = curl_init();
    // curl_setopt_array($curl, array(    
    //   CURLOPT_URL => $url,
    //   CURLOPT_HEADER => true,
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_NOBODY => true));

    // $header = explode("\n", curl_exec($curl));
    // curl_close($curl);

    // if (strpos($header[0],'301') || strpos($header[0],'302')) {
    //   if(is_array($header['Location'])) {
    //     return $header['Location'][count($header['Location'])-1];
    //   } else {
    //     return $header['Location'];
    //   }
    // } else {
    //   return $url;
    // }
  }
  $url = getRealurl('https://libermg.ncyu.edu.tw/cgi-bin/smartweaver/browse.cgi?ccd=DqySwM&o=e0&s=c-1-114082');
  echo $url;
  // $jsonFilePath = './test.json';
  // $SID = $_GET['sid'];

  // $univInfo = getJson($jsonFilePath);

  // // get Univ detail
  // $appID = null;
  // $appKey = null;
  // $connectingUrl = null;

  // foreach ($univInfo as $univ) {
  //   if(strcasecmp($univ['id'], $SID) == 0) {
  //     $appID = $univ['appID'];
  //     $appKey = $univ['appKey'];
  //     $connectingUrl = $univ['connectingUrl'];
  //     break;
  //   }
  // }
  // echo 'AppID='.$appID.'</br>AppKey='.$appKey.'</br>ConnectingUrl='.$connectingUrl;

  // function getJson($path) {
  //   $getJsonData = file_get_contents($path);
  //   $decodeJsonData = json_decode($getJsonData, true);

  //   return $decodeJsonData;
  // }

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
?>