<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  header("Content-Security-Policy: upgrade-insecure-requests");
  date_default_timezone_set('Asia/Taipei');

  $randomBookQuantity = 50;
  $apiConnection = "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=s3448411.main.eit&pwd=ebs7077&db=eon&query=LO system.nl-s3448411&numrec=".$randomBookQuantity;
  
  $keyword = str_replace(' ', '+', $_GET['uquery']);

  $profile = $_GET['profile'];
  $custID = $_GET['custID'];

  // $keyword = "blockchain";

  $bookInfoList = getBookInfoFromServer($apiConnection, $keyword, $profile, $custID);

  echo json_encode($bookInfoList, JSON_NUMERIC_CHECK);

  function getBookInfoFromServer($apiUrl, $keyword, $profile, $custID) {
    $result = array();

    // get value from API
    $connectApiUrl = $apiUrl."&query=".$keyword;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $connectApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $xml = curl_exec($ch);
    $parseXml = simplexml_load_string($xml);
    curl_close($ch);

    foreach($parseXml->SearchResults->records->children() as $rec) {
      // get url and parse
      $parseUrlParam = parse_url($rec->plink);
      parse_str($parseUrlParam['query'], $query);
      $AN = $query['AN'];

      $doidParent = $rec->header->controlInfo->artinfo->formats->fmt->attributes();
      $doid = $doidParent['doid'];

      $parseUrlParam = parse_url($rec->plink);

      $imgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id='.$doid.'&s=l';
      $directionUrl = 'http://search.ebscohost.com/login.aspx?direct=true&db=nlebk&AN='.$AN.'&site=ehost-live&custid='.$custID.'&authtype=ip,uid&groupid=main&profileid='.$profile.'&scope=site';
      $onErrorImgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id=NL$'.$AN.'$EPUB&s=l';
      $title = $rec->header->controlInfo->bkinfo->btl;
      $tempItem = array('title' => strval($title), 'imgUrl' => strval($imgUrl), 'directionUrl' => strval($directionUrl), 'onErrorUrlImg' => strval($onErrorImgUrl));
      array_push($result, $tempItem);
    }

    return $result;
  }
?>
