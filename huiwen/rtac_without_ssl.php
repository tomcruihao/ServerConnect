<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $getOriginalUrl = $_GET['oriurl'];

  function getRealurl($url) {
    $ch = curl_init();
	$timeout = 0;
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

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
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch1);
    curl_close($ch1);
    echo $response;
  }

  $url = getRealurl($getOriginalUrl);

  $getDomainName = parse_url($url);
  $domainName = $getDomainName["host"];
  $port = $getDomainName["port"];

  echo $url.'@@@@@';
  $url_extract = explode("=",$url);
  echo 'ID: '.$url_extract.'@@@';

  if ($port) {
    getContent($domainName.":".$port."/opac/ajax_item.php?marc_no=".$url_extract[1]);
  } else {
    getContent($domainName."/opac/ajax_item.php?marc_no=".$url_extract[1]);
  }
?>