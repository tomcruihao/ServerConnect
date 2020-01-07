<?php
  header("Content-Type:application/json; charset=utf-8");

  $connectUrl = 'http://47.104.60.189:8085/services/WebService?wsdl';
  $libCode = '301000';
  $systemid = '3';

  $userName = isset($_POST['userName']) ? $_POST['userName'] : '';
  $userPhone = isset($_POST['userPhone']) ? $_POST['userPhone'] : '';
  $userEmail = isset($_POST['userEmail']) ? $_POST['userEmail'] : '';

  $jTitle = isset($_POST['title']) ? $_POST['title'] : '';
  $jMagtitle = isset($_POST['magtitle']) ? $_POST['magtitle'] : '';
  $jMayyear = isset($_POST['mayyear']) ? $_POST['mayyear'] : '';
  $jVolume = isset($_POST['volnum']) ? $_POST['volnum'] : '';
  $jMagnum = isset($_POST['magnum']) ? $_POST['magnum'] : '';
  $jPagenum = isset($_POST['pagenum']) ? $_POST['pagenum'] : '';
  $jISSN = isset($_POST['issn']) ? $_POST['issn'] : '';
  $jDOI = isset($_POST['doi']) ? $_POST['doi'] : '';

  // echo $userName.' '.$userPhone.' '.$userEmail.' '.$jTitle.' '.$jMagtitle.' '.$jMayyear.' '.$jVolume.' '.$jMagnum.' '.$jPagenum.' '.$jISSN.' '.$jDOI;

  $client = new SoapClient($connectUrl);

  $params = '{
    "libcode": "'.$libCode.'",
    "useremail": "'.$userEmail.'",
    "userphone": "'.$userPhone.'",
    "title": "'.$jTitle.'",
    "magtitle": "'.$jMagtitle.'",
    "issn": "'.$jISSN.'",
    "mayyear": "'.$jMayyear.'",
    "volnum": "'.$jVolume.'",
    "magnum": "'.$jMagnum.'",
    "pagenum": "'.$jPagenum.'",
    "systemid": "'.$systemid.'",
    "doi": "'.$jDOI.'"
  }';

  // Invoke WS method (Function1) with the request params 
  $response = $client->__soapCall("referReqmag", array($params));

  echo $response;
?>