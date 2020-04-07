<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  include 'getAuth.php';

  // varibles
  $getNumberOfArticles = 8;
  

  $keyword = '';
  if(isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
  } else {
    $res = array('status' => 'error', 'message' => 'No Value');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    exit();
  }
  
  function getArticle($data) {
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


    curl_setopt($curl, CURLOPT_URL, 'https://eds-api.ebscohost.com/edsapi/rest/Search');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
  }

  function processArticles($ary_articles) {
    foreach($ary_articles['Data']['Records'] as $key => $row) {

      foreach($row['Items'] as $itemKey => $itemRow) {
        
        print_r($itemRow);
      }
      // print_r($row);
    }
  }

  $articleParams = array(
    "SearchCriteria" => array(
      "Queries" => array(array("Term" => $keyword)),
      "SearchMode" => "all",
      "IncludeFacets" => "n",
      "Sort" => "relevance",
      "AutoSuggest" => "n",
      "AutoCorrect" => "n",
    ),
    "RetrievalCriteria" => array(
      "View" => "detailed",
      "ResultsPerPage" => 20,
      "PageNumber" => 1,
      "Highlight" => "n",
      "IncludeImageQuickView" => "n",
    ),
    "Actions" => null
  );
  $articleParams = json_encode($articleParams, JSON_UNESCAPED_UNICODE);
  
  $result = getArticle($articleParams);

  $result_ary = json_decode($result, true);
  
  $lastResult = processArticles($result_ary['SearchResult']);


  // print the result
  // echo json_encode($result_ary['SearchResult'], JSON_UNESCAPED_UNICODE);
?>
