<?php
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json; charset=utf-8');
  header( 'Content-Type:text/html;charset=utf-8 ');
  date_default_timezone_set('Asia/Taipei');

  $randomBookQuanty = 20;

  // Get the contents of the JSON file 
  $strJsonFileContents = file_get_contents("./booklist.json");

  // Convert to array 
  $totalBooklist = json_decode($strJsonFileContents, true);

  $randomBooklist = getRandomBookList($totalBooklist, $randomBookQuanty);

  $bookInfoList = getBookInfoFromServer($randomBooklist);

  // convert to json and display
  echo json_encode($bookInfoList, JSON_NUMERIC_CHECK);

  function getBookInfoFromServer($booklist) {
    $result = array();

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
    echo $apiUrl;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $xml = curl_exec($ch);
    $parseXml = simplexml_load_string($xml);
    curl_close($ch);

    foreach($parseXml->SearchResults->records->children() as $rec) {
      // get url and parse
      $parseUrlParam = parse_url($rec->plink);
      parse_str($parseUrlParam['query'], $query);
      $parts = parse_url($url);
      $AN = $query['AN'];
      $imgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id=NL$'.$AN.'$PDF&s=l';
      echo '<img src="'.$imgUrl.'">';
      $directionUrl = 'http://search.ebscohost.com/login.aspx?direct=true&db=nlebk&AN='.$AN.'&site=ehost-live&custid=s1213459&authtype=ip,uid&groupid=main&profileid=ehost&scope=site';
      $onErrorImgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id=NL$'.$AN.'$EPUB&s=r';
      $title = $rec->header->controlInfo->bkinfo->btl;
      $tempItem = array('title' => strval($title), 'imgUrl' => strval($imgUrl), 'directionUrl' => strval($directionUrl), 'onErrorUrlImg' => strval($onErrorImgUrl));
      array_push($result, $tempItem);
    }

    return $result;
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