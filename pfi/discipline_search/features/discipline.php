<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  session_start();

  $resultsPerPage = 100;

  $keyword = '';
  if(isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
  } else {
    $res = array('status' => 'error', 'message' => 'No Value');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    exit();
  }

  $original_articleParams = array(
    "SearchCriteria" => array(
      "Queries" => array(array("Term" => $keyword)),
      "IncludeFacets" => "n",
      "FacetFilters" => "",
      "Limiters" => "",
      "Sort" => "relevance",
      "AutoSuggest" => "n",
      "AutoCorrect" => "n",
    ),
    "RetrievalCriteria" => array(
      "View" => "brief",
      "ResultsPerPage" => $resultsPerPage,
      "PageNumber" => 1,
      "Highlight" => "n",
    ),
    "Actions" => null // movePage(1)
  );

  $articleParams = json_encode($original_articleParams, JSON_UNESCAPED_UNICODE);
  $result = getPFI_Data($articleParams);
  
  // check result number is bigger than search per page or not
  $ary_result = json_decode($result, true);

  // get number of total result
  $totalResult = $ary_result['SearchResult']['Statistics']['TotalHits'];

  $responseResult = [];
  $responseResult = getAllTitles($responseResult, $ary_result['SearchResult']);

  if(intval($totalResult) > $resultsPerPage) {
    $loopPages = ceil($totalResult/$resultsPerPage);
    $movePage = "";

    for($index = 1; $index < $loopPages; $index++ ) {
      sleep(1);
      $movePage = "movePage(".$index.")";
      $tempParam = $original_articleParams;
      $tempParam["Actions"] = array($movePage);
      $tempParam = json_encode($tempParam, JSON_UNESCAPED_UNICODE);

      $tempResult = json_decode(getPFI_Data($tempParam), true);
      $responseResult = getAllTitles($responseResult, $tempResult['SearchResult']);
    }
  }

  // response the data
  echo json_encode($responseResult, JSON_UNESCAPED_UNICODE);



  function getPFI_Data($data) {
    $curl = curl_init();

    // set method and data
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    // set header
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Accept: application/json",
      "x-authenticationToken:".$_SESSION["AuthenticationToken"],
      "x-sessionToken:".$_SESSION["SessionToken"]
    ));

    curl_setopt($curl, CURLOPT_URL, 'https://eds-api.ebscohost.com/edsapi/publication/Search');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    $result = curl_exec($curl);

    curl_close($curl);
    return $result;
  }

  function getAllTitles($originalAry, $ary_SearchResult) {
    $ary_result = $originalAry;
    $records = $ary_SearchResult['Data']['Records'];

    foreach ($records as $key => $value) {
      array_push($ary_result, $value);
    }

    return $ary_result;
  }
?>
