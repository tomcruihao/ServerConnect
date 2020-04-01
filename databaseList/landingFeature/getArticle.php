<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  if(isset($_SESSION['AuthenticationToken']) && isset($_SESSION['SessionToken'])) {
    include 'getAuth.php';
  }

  function getArticle($data = false) {
    $curl = curl_init();

    // set method and data
    curl_setopt($curl, CURLOPT_POST, 1);
    if ($data) {
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    // set header
    $headerInfo = array(
      'x-authenticationToken' => $_SESSION['AuthenticationToken'],
      'x-sessionToken' => $_SESSION['SessionToken']
    );
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerInfo);

    curl_setopt($curl, CURLOPT_URL, 'https://eds-api.ebscohost.com/edsapi/rest/Search');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
  }
  $articleParams = array(
    "SearchCriteria" => array(
      "Queries" => array(array("Term" => "nature")),
      "SearchMode" => "all",
      "IncludeFacets" => "y",
      "Sort" => "relevance",
      "AutoSuggest" => "n",
      "AutoCorrect" => "n",
    ),
    "RetrievalCriteria" => array(
      "View" => "brief",
      "ResultsPerPage" => "20",
      "PageNumber" => "1",
      "Highlight" => "y",
      "IncludeImageQuickView" => "n",
    ),
    "Actions" => null
  );
  $articleParams = json_encode($articleParams, JSON_UNESCAPED_UNICODE);
  print_r($articleParams);
  
  print_r(getArticle($articleParams));
  // print_r(getArticle($articleParams));
?>
