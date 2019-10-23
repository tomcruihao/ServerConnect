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

  // get the length of list
  
  echo $randomBooklist;


  function getRandomBookList($booklist, $quantity) {
    $elementCount = count($bookList);
    echo $elementCount - 1;
    $listAry = array();
    // while(count($listAry) < 5) {
    //   array_push($listAry, mt_rand(0, $elementCount - 1));
    //   $listAry = array_unique($listAry);
    // }
    print_r($listAry);
    // while(listAry.length < randomQuantity) {
    //   let randomValue = Math.floor(Math.random()*recommandBookLength);
    //   if(!listAry.includes(randomValue)) {
    //     listAry.push(randomValue);
    //   }
    // }
    return $listAry;
  }
  // foreach ($univInfo as $univ) {
  //   if(strcasecmp($univ['id'], $sid) == 0) {
  //     $appID = $univ['appID'];
  //     $appKey = $univ['appKey'];
  //     $connectingUrl = $univ['connectingUrl'];
  //     break;
  //   }
  // }

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