<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Taipei');

  $randomBookQuanty = 20;

  // Get the contents of the JSON file 
  $strJsonFileContents = file_get_contents("./booklist.json");

  // Convert to array 
  $totalBooklist = json_decode($strJsonFileContents, true);

  $randomBooklist = getRandomBookList($totalBooklist, $randomBookQuanty);

  $bookInfoList = getBookInfoFromServer($randomBooklist);

  function getBookInfoFromServer($booklist) {
    // generate query
    $queryContent = 'IB+';
    foreach($booklist as $key => $value) {
      if($key) {
        $queryContent = $queryContent.'+or+'.$value['isbn'];
      } else {
        $queryContent = $queryContent.$value['isbn'];
      }
    }

    // // get value from API
    $apiUrl = "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=tylee.main.eit&&pwd=ebs3705&db=edsebk&query=".$queryContent;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $xml = curl_exec($ch);
    $parseXml = simplexml_load_string($xml);
    curl_close($ch);
    // echo $parseXml->SearchResults->records->rec->plink;
    foreach($parseXml->searchResponse->SearchResults->records->rec->children() as $rec) {
      echo $rec->plink."<br>";
    }
    // var_dump(json_decode($output, true));
    // $decodeVal = json_decode($output, true);
    // print_r($decodeVal);
  }

  function getRandomBookList($booklist, $quantity) {
    $elementCount = count($booklist);
    $result = array();
    $randomNumAry = array();

    while(count($randomNumAry) <= $quantity) {
      array_push($randomNumAry, mt_rand(0, $elementCount - 1));
      $randomNumAry = array_unique($randomNumAry);
    }

    // copy the data in result array
    foreach($randomNumAry as $value){
      array_push($result, $booklist[$value]);
    }
    // while(listAry.length < randomQuantity) {
    //   let randomValue = Math.floor(Math.random()*recommandBookLength);
    //   if(!listAry.includes(randomValue)) {
    //     listAry.push(randomValue);
    //   }
    // }
    return $result;
  }

  // // create curl resource
  // $ch = curl_init();
  // // set url 
  // curl_setopt($ch, CURLOPT_URL, "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=tylee.main.eit&&pwd=ebs3705&db=edsebk&query=IB+9780195141832");
  // // $output contains the output json
  // $output = curl_exec($ch);
  // // close curl resource to free up system resources 
  // curl_close($ch);
  // // {"name":"Baron","gender":"male","probability":0.88,"count":26}
  // var_dump(json_decode($output, true));
?>