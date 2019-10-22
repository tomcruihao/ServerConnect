<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  // create curl resource
  $ch = curl_init();
  // set url 
  curl_setopt($ch, CURLOPT_URL, "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=tylee.main.eit&&pwd=ebs3705&db=edsebk&query=IB+9780195141832");
  // $output contains the output json
  $output = curl_exec($ch);
  // close curl resource to free up system resources 
  curl_close($ch);
  // {"name":"Baron","gender":"male","probability":0.88,"count":26}
  var_dump(json_decode($output, true));
?>