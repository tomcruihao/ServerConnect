<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  header("Content-Type:text/html; charset=utf-8");


  // Initialize WS with the WSDL
  $client = new SoapClient("http://47.104.60.189:8085/services/WebService?wsdl");

  // Invoke WS method (Function1) with the request params 
  $response = $client->__soapCall("referReqmag", array('{"libcode":"301000","useremail":"chchang@ebsco.com","title":"test","systemid":"3"}'));

  echo $response;
?>