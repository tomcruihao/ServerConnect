<?php
  header("Access-Control-Allow-Origin: *");
  // header("Content-Type:text/html; charset=utf-8");
  header('Content-Type: application/json;charset=UTF-8');

  $apiUrl = $_GET['oriurl'];
  // $term = $_GET['term'];
  // $AN = $_GET['an'];

  // $connectUrl = $domainUrl.'/holding?('.$term.')'.$AN;
  getContent($apiUrl);
  // getContent('http://dev.jiatu.info:4000/holding?(szl)1005891840');

  function getContent($apiUrl) {
    $ch1 = curl_init();
    $http_headers = array(
      'User-Agent: Junk', // Any User-Agent will do here 
    );
    curl_setopt($ch1,CURLOPT_URL,$apiUrl);
    curl_setopt($ch1, CURLOPT_HTTPHEADER, $http_headers); 
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 4);
    // curl_setopt($ch1, CURLOPT_HEADER, true); 
    $response = curl_exec($ch1);
    curl_close($ch1);
    echo $response;

    // $getJsonData = file_get_contents($apiUrl);
    // $decodeJsonData = json_decode($getJsonData, true);
    // echo $decodeJsonData;
  }
?>
