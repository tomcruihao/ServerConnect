<? php
  $objSoapClient = new SoapClient("http://47.104.60.189:8085/services/WebService?wsdl");
  $param = array(
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
  $out = $objSoapClient->ValidateZip($param);
  $data = $out->ValidateZipResult;
  echo $data;
?>