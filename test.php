<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

function CallAPI($method, $url, $data = false) {
  $curl = curl_init();

  switch ($method)
  {
    case "POST":
      curl_setopt($curl, CURLOPT_POST, 1);
      if ($data)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      break;
    case "PUT":
      curl_setopt($curl, CURLOPT_PUT, 1);
      break;
    default:
      if ($data)
        $url = sprintf("%s?%s", $url, http_build_query($data));
  }

  // Optional Authentication:
  // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);

  curl_close($curl);

  return $result;
}
$userInfo = array(
    'UserName' => 'J4VAGI77SD^hDOkw0uCV',
    'Password' => 'H5r3CUIj^ZnEXSR$hbO^',
    'Profile' => 'api',
    'Customer ID' => 'J4VAGI77SD^hDOkw0uCV'
);

$apiResponse = CallAPI("POST", "https://eds-api.ebscohost.com/Console/IntegratedAuthentication/ValidateUser", )
print_r($apiResponse);
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