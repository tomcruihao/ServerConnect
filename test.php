<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  date_default_timezone_set('Asia/Taipei');

  // get parameter from URL
  $marcNum = $_GET['marc'];
  
  // set parameter
  $appID = 'eds';
  $appKey = 'z18gEZ0bzPMeGpai';
  $connectingUrl = 'http://opac.lib.nankai.edu.cn/api/itemgo.php';


  $timestamp = getCurrentTime();
  $stringBinding = $marcNum.$timestamp.$appKey;


  $sign = md5($stringBinding);
  

  // echo $connectingUrl.'?marc_no='.$marcNum.'&appid='.$appID.'&time='.$timestamp.'&sign='.$sign;

  getUnivInfo();

  // return `${connectUrl}?marc_no=${marcNum}&appid=${appID}&time=${timestamp}&sign=${sign}`;

  function getCurrentTime() {
    $currentTime = time();
    return trim(date("Y-m-dH:i:s", $currentTime), ' ');
  }

  function getUnivInfo() {
    // json object.
    $univInfo = json_decode('[{"id": "s1213459", "appID": "eds", "appKey": "z18gEZ0bzPMeGpai", "connectingUrl": "http://opac.lib.nankai.edu.cn/api/itemgo.php"},
      {"id": "29", "appID": "eds", "appKey": "z18gEZ0bzPMeGpai", "connectingUrl": "http://opac.lib.hit.edu.cn/api/itemgo.php"}
    ]', true);
    print_r($univInfo);
    echo $univInfo;
    // $univInfo = {"universities": [
    //   {"id": "s1213459", "appID": "eds", "appKey": "z18gEZ0bzPMeGpai", "connectingUrl": "http://opac.lib.nankai.edu.cn/api/itemgo.php"},
    //   {"id": "29", "appID": "eds", "appKey": "z18gEZ0bzPMeGpai", "connectingUrl": "http://opac.lib.hit.edu.cn/api/itemgo.php"}
    // ]};


    foreach ($data as $emp) {
      echo $emp['id']."<br/>";
    }
    // foreach($json->universities as $row) {
    //   foreach($row as $key => $val) {
    //     echo $key . ': ' . $val;
    //     echo '<br>';
    //   }
    // }

    //     // Option 1: through the use of an array.
    // $jsonArray = json_decode($contents,true);

    // $key = "firstName";

    // $firstName = $jsonArray[$key];


    // // Option 2: through the use of an object.
    // $jsonObj = json_decode($contents);

    // $firstName = $jsonObj->$key;
  }
  // $getOriginalUrl = $_GET['oriurl'];

  // function getrealurl($url){
  //   $header = @get_headers($url,1);  //默认第二个参数0，可选1，返回关联数组
  //   if(!$header){
  //     exit('无法打开此网站'.$url);
  //   }
  //   //var_dump($header);
  //   if (strpos($header[0],'301') || strpos($header[0],'302')) {
  //     if(is_array($header['Location'])) {
  //       return $header['Location'][count($header['Location'])-1];
  //     } else {
  //       return $header['Location'];
  //     }
  //   } else {
  //     return $url;
  //   }
  // }

  // // $url = 'http://opac.lib.nankai.edu.cn/api/itemgo.php?marc_no=0000930184&appid=eds&time=2019-06-2815:54:07&sign=0f5565e3fa910d1bd23959ebe4c7d172';
  // $url = getrealurl($getOriginalUrl);
  // $url_extract = explode("=",$url);

  // echo file_get_contents("http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=".$url_extract[1]);
  // // echo $url_extract[1];
  // // header("Location: http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=".$url_extract[1]);

  // // http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=44737544646d47744264694d7350795a725538426f413d3d
  // // echo '真实的url为：'.$url;
?>