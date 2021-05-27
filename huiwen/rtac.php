<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $getOriginalUrl = $_GET['oriurl'];

  function getRealurl($url) {
    // If the url didn't redirect the URL, It may cause by server permission. type the command as below
    // sudo setsebool httpd_can_network_connect 1

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $html = curl_exec($ch);

    $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    return $redirectedUrl;
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

  $url = getRealurl($getOriginalUrl);

  $getDomainName = parse_url($url);
  $protocol = $getDomainName["scheme"];
  $domainName = $getDomainName["host"];
  $port = $getDomainName["port"];

  parse_str($getDomainName['query'], $query);
  $marcNumber = $query['marc_no'];


  $url_extract = explode("=",$url);
  if ($port) {
    getContent($protocol.'://'.$domainName.":".$port."/opac/ajax_item.php?marc_no=".$marcNumber);
  } else {
    getContent($protocol.'://'.$domainName."/opac/ajax_item.php?marc_no=".$marcNumber);
  }
?>