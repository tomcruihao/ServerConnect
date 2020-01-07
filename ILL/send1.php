<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  header("Content-Type:text/html; charset=utf-8");

  // $objSoapClient = new SoapClient("http://47.104.60.189:8085/services/WebService?wsdl");
  // $param = array(
  //   "libcode"=>"301000",
  //   "useremail"=>"chchang@ebsco.com",
  //   "userphone"=>"",
  //   "title"=>"test",
  //   "magtitle"=>"",
  //   "issn"=>"",
  //   "mayyear"=>"",
  //   "volnum"=>"",
  //   "magnum"=>"",
  //   "pagenum"=>"",
  //   "systemid"=>"3",
  //   "doi"=>""
  // );
  // $out = $objSoapClient->ValidateZip($param);
  // $data = $out->ValidateZipResult;
  // echo $data;


  // Initialize WS with the WSDL
  $client = new SoapClient("http://47.104.60.189:8085/services/WebService?wsdl");

  // Set request params
  $params = array(
    "libcode"=>"301000",
    "useremail"=>"chchang@ebsco.com",
    "userphone"=>"",
    "title"=>"test",
    "magtitle"=>"",
    "issn"=>"",
    "mayyear"=>"",
    "volnum"=>"",
    "magnum"=>"",
    "pagenum"=>"",
    "systemid"=>"3",
    "doi"=>""
  );

  // Invoke WS method (Function1) with the request params 
  $response = $client->__soapCall("referReqmag", array($params));

  // Print WS response
  // var_dump($response);
  echo $response;
  // print_r($params);
?>