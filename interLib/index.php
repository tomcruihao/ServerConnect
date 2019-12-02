<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $domainUrl = $_POST['oriurl'];
  $term = $_POST['term'];
  $AN = $_POST['an'];

  $connectUrl = $domainUrl.'/holding?('.$term.')'.$AN;
  echo $connectUrl;
  // getContent('http://dev.jiatu.info:4000/holding?(szl)1005891840');

  // function getContent($url) {
  //   $ch1 = curl_init();
  //   curl_setopt($ch1,CURLOPT_URL,$url);
  //   curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
  //   curl_setopt($ch1,CURLOPT_CONNECTTIMEOUT, 4);
  //   $response = curl_exec($ch1);
  //   curl_close($ch1);
  //   echo $response;
  // }
?>
<?php
  $base64Code = $_POST['code'];
  $pageCode = base64_decode($base64Code);
  echo $pageCode;
?>