<?php
  function get_proxy_site_page( $url )
  {
      $options = [
          CURLOPT_RETURNTRANSFER => true,     // return web page
          CURLOPT_HEADER         => true,     // return headers
          CURLOPT_FOLLOWLOCATION => true,     // follow redirects
          CURLOPT_ENCODING       => "",       // handle all encodings
          CURLOPT_AUTOREFERER    => true,     // set referer on redirect
          CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
          CURLOPT_TIMEOUT        => 120,      // timeout on response
          CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
      ];

      $ch = curl_init($url);
      curl_setopt_array($ch, $options);
      $remoteSite = curl_exec($ch);
      $header = curl_getinfo($ch);
      curl_close($ch);

      $header['content'] = $remoteSite;
      return $header;
  }

  $url = get_proxy_site_page('https://libermg.ncyu.edu.tw/cgi-bin/smartweaver/browse.cgi?ccd=bPrCxo&o=e0&s=c-1-230784');
  print_r($url);
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