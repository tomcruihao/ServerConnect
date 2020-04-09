<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  header("Content-Security-Policy: upgrade-insecure-requests");

  $resultAmount = 8;
  $apiConnection = "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=jaychang.main.edu-eit&&pwd=ebs1927&db=ehh";

  $keyword = str_replace(' ', '+', $_GET['uquery']);

  $bookInfoList = getInfoFromServer($apiConnection, $keyword, $resultAmount);

  echo json_encode($bookInfoList, JSON_NUMERIC_CHECK);

  function getInfoFromServer($apiUrl, $keyword, $resultAmount) {
    $result = array();

    // get value from API
    $connectApiUrl = $apiUrl."&query=".$keyword;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $connectApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $xml = curl_exec($ch);
    $parseXml = simplexml_load_string($xml);
    curl_close($ch);

    $counter = 0;

    foreach($parseXml->SearchResults->records->children() as $rec) {
      
      $pLink = $rec->plink;
      $title = $rec->header->controlInfo->artinfo->tig->atl;
      $abstract = $rec->header->controlInfo->artinfo->ab;
      $ary_authors = $rec->header->controlInfo->artinfo->aug->au;
      $authors = '';
      foreach($ary_authors as $key => $author) {
        if($key > 0) {
          $authors = $authors.'\; '.$author;
        } else {
          $authors = $author;
        }
      }

      $tempItem = array('title' => strval($title), 'pLink' => strval($pLink), 'abstract' => strval($abstract), 'authors' => strval($authors));
      if($counter < $resultAmount) {
        array_push($result, $tempItem);
        $counter++;
      }
    }

    return $result;
  }
?>
