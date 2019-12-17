<?php
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Taipei');

  $connectUrl = 'http://47.104.60.189:8085/services/WebService?wsdl';

  $userName = $_POST['userName'];
  $userPhone = $_POST['userPhone'];
  $userEmail = $_POST['userEmail'];

  $jTitle = $_POST['title'];
  $jMagtitle = $_POST['magtitle'];
  $jMayyear = $_POST['mayyear'];
  $jVolume = $_POST['volnum'];
  $jMagnum = $_POST['magnum'];
  $jPagenum = $_POST['pagenum'];
  $jISSN = $_POST['issn'];
  $jDOI = $_POST['doi'];

  echo $userName.' '.$userPhone.' '.$userEmail.' '.$jTitle.' '.$jMagtitle.' '.$jMayyear.' '.$jVolume.' '.$jMagnum.' '.$jPagenum.' '.$jISSN.' '.$jDOI;
  // array(
  //   "libcode"=>$nm_patient,
  //   "useremail"=>$id_patno,
  //   "userphone"=>$st_sex,
  //   "title"=>$dt_birth,
  //   "magtitle"=>$st_age,
  //   "mayyear"=>$id_patient,
  //   "volnum"=>$id_bed,
  //   "magnum"=>$txtInfo,
  //   "pagenum"=>$imgInfo,
  //   "systemid"=>$imgDraw,
  //   "issn"=>$imgSign,
  //   "doi"=>$imgSign
  // );
  function checkDataInfo($formInfo) {
    // required: libcode, useremail
    return 0;
  }

  function getContent($url, $formInfo) {
    $ch1 = curl_init();
    curl_setopt($ch1,CURLOPT_URL,$url);
    curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch1,CURLOPT_CONNECTTIMEOUT, 4);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendInfo));
    $response = curl_exec($ch1);
    curl_close($ch1);
    // echo $response;
  }
?>