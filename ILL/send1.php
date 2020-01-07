<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  header("Content-Type:text/html; charset=utf-8");


  // Initialize WS with the WSDL
  $client = new SoapClient("http://47.104.60.189:8085/services/WebService?wsdl");

  $params = '{
    "libcode": "301000",
    "useremail": "chchang@ebsco.com",
    "userphone": "",
    "title": "Nature Experiences and Adults’ Self-Reported Pro-environmental Behaviors: The Role of Connectedness to Nature and Childhood Nature Experiences.",
    "magtitle": "",
    "issn": "",
    "mayyear": "",
    "volnum": "",
    "magnum": "",
    "pagenum": "",
    "systemid": "3",
    "doi": ""
  }';

  // Invoke WS method (Function1) with the request params 
  $response = $client->__soapCall("referReqmag", array($params));

  echo $response;
?>
