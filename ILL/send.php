<?php
  header("Content-Type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Taipei');

  $connectUrl = '';

  $Name = $_POST['Name'];
  $phone = $_POST['phone'];

  array(
    "libcode"=>$nm_patient,
    "useremail"=>$id_patno,
    "userphone"=>$st_sex,
    "title"=>$dt_birth,
    "magtitle"=>$st_age,
    "mayyear"=>$id_patient,
    "volnum"=>$id_bed,
    "magnum"=>$txtInfo,
    "pagenum"=>$imgInfo,
    "systemid"=>$imgDraw,
    "issn"=>$imgSign,
    "doi"=>$imgSign
  );
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