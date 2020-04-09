<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  header("Content-Security-Policy: upgrade-insecure-requests");

  $resultAmount = 8;
  $apiConnection = "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=jaychang.main.edu-eit&&pwd=ebs1927&db=ehh";

  $keyword = str_replace(' ', '+', $_GET['uquery']);
  $profile = $_GET['profile'];
  $custID = $_GET['custID'];

  // $keyword = "blockchain";

  $bookInfoList = getInfoFromServer($apiConnection, $keyword, $profile, $custID);

  // echo json_encode($bookInfoList, JSON_NUMERIC_CHECK);

  function getInfoFromServer($apiUrl, $keyword, $profile, $custID) {
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
      
      $pLink = $rec->plink;
      $title = $rec->header->controlInfo->artinfo->tig->atl;
      $abstract = $rec->header->controlInfo->artinfo->ab;
      $authors = $rec->header->controlInfo->artinfo->aug->au;
      while ($author = current($authors)) {
        echo $author;
        echo next($authors) ? ', ' : null;
      }

      $tempItem = array('title' => strval($title), 'pLink' => strval($pLink), 'abstract' => strval($abstract));
      array_push($result, $tempItem);
    }

    return $result;
  }
?>
