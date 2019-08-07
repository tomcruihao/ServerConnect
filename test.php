<?php

$jsonFilePath = './test.json';



//Print data
print_r(getJson($jsonFilePath));

function getJson($path) {
  $jsonRawData = file_get_contents($path);
  $jsonData = json_decode($json, true);
  return $jsonData;
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

?>