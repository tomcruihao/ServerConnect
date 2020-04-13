<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $getOriginalUrl = $_GET['oriurl'];


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

  function getContent($url) {
    $ch1 = curl_init();
    curl_setopt($ch1,CURLOPT_URL,$url);
    curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch1,CURLOPT_CONNECTTIMEOUT, 4);
    $response = curl_exec($ch1);
    curl_close($ch1);
    echo $response;
  }

  // $url = 'http://opac.lib.nankai.edu.cn/api/itemgo.php?marc_no=0000930184&appid=eds&time=2019-06-2815:54:07&sign=0f5565e3fa910d1bd23959ebe4c7d172';
  $url = getRealurl($getOriginalUrl);

  echo $url;

  $getDomainName = parse_url($url);
  $domainName = $getDomainName["host"];
  $port = $getDomainName["port"];


  // $url_extract = explode("=",$url);
  // if ($port) {
  //   getContent($domainName.":".$port."/opac/ajax_item.php?marc_no=".$url_extract[1]);
  // } else {
  //   getContent($domainName."/opac/ajax_item.php?marc_no=".$url_extract[1]);
  // }
?>