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

  function processArticles($ary_articles, $getNumberOfArticles) {
    $result = $ary_articles;
    $articleCounter = 0;
    $ary_tempRecords = [];
    foreach($ary_articles['Data']['Records'] as $key => $row) {
      // $allValueExist = true;
      $getKeys = ["Title", "Author", "TitleSource", "Abstract"];
      $countDescribe = count($getValueDescribe);
      
      // check all item have data
      // foreach($row['Items'] as $itemKey => $itemRow) {
      //   if(empty($itemRow['Data'])) {
      //     $allValueExist = false;
      //   }
      // }

      foreach($row['Items'] as $itemKey => $itemRow) {
        // array_key_exists($getKeys, $itemRow['Name']);
        if(in_array($getKeys, $itemRow['Name'])) {
          $countDescribe = $countDescribe - 1;
        }
      }

      echo $countDescribe;
      // put this record in temp array
      if($countDescribe === 0 && ($articleCounter < $getNumberOfArticles)) {
        array_push($ary_tempRecords, $row);
        $articleCounter = $articleCounter + 1;
      }
    }

    // replace the Records of result
    $result['Data']['Records'] = $ary_tempRecords;
    return $result;
  }
  
  $articleParams = array(
    "SearchCriteria" => array(
      "Queries" => array(array("Term" => $keyword)),
      "SearchMode" => "all",
      "Limiters" => array(array("Id" => "LA99", "Values" => array("English","Chinese"))),
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
  
  $lastResult = processArticles($result_ary['SearchResult'], $getNumberOfArticles);


  // print the result
  echo json_encode($lastResult, JSON_UNESCAPED_UNICODE);
?>
