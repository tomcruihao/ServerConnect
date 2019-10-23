<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Taipei');

  $randomBookQuanty = 20;

  // Get the contents of the JSON file 
  $strJsonFileContents = file_get_contents("./booklist.json");
  // Convert to array 
  $totalBooklist = json_decode($strJsonFileContents, true);
  // var_dump($array); // print array
  $randomBooklist = getRandomBookList($totalBooklist, $randomBookQuanty);

  $bookInfoList = getBookInfoFromServer();
  // get the length of list
  
  print_r($randomBooklist);

  function getBookInfoFromServer($booklist) {

    foreach($booklist as $key => $value) {
      echo $key.$value;
      // $ch = curl_init();
      // curl_setopt($ch, CURLOPT_URL, "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=tylee.main.eit&&pwd=ebs3705&db=edsebk&query=IB+9780195141832");
      // $output = curl_exec($ch);
      // curl_close($ch);
      // var_dump(json_decode($output, true));
    }
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