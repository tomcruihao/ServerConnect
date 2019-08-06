<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $getOriginalUrl = $_GET['oriurl'];
  echo $getOriginalUrl;

  function getrealurl($url){
    $header = @get_headers($url,1);  //默认第二个参数0，可选1，返回关联数组
    if(!$header){
      exit('无法打开此网站'.$url);
    }
    //var_dump($header);
    if (strpos($header[0],'301') || strpos($header[0],'302')) {
      if(is_array($header['Location'])) {
        return $header['Location'][count($header['Location'])-1];
      } else {
        return $header['Location'];
      }
    } else {
      return $url;
    }
  }

  function newGetrealurl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $html = curl_exec($ch);

    $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    echo "Original URL:   " . $url . "\n";
    echo "Redirected URL: " . $redirectedUrl . "\n";
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



  // $url = 'http://opac.lib.nankai.edu.cn/api/itemgo.php?marc_no=0000930184&appid=eds&time=2019-06-2815:54:07&sign=0f5565e3fa910d1bd23959ebe4c7d172';
  $url = newGetrealurl($getOriginalUrl);
  $url_extract = explode("=",$url);

  echo file_get_contents("http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=".$url_extract[1]);
  // echo $url_extract[1];
  // header("Location: http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=".$url_extract[1]);

  // http://opac.lib.nankai.edu.cn/opac/ajax_item.php?marc_no=44737544646d47744264694d7350795a725538426f413d3d
  // echo '真实的url为：'.$url;
?>