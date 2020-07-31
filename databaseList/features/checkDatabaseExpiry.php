<?php
  // Server setting: crontab -e
  use PHPMailer\PHPMailer\PHPMailer;

  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  $jsonFile_direct = dirname(dirname(__FILE__)).'/data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  foreach($resourceList as $key => $value) {
    $expired = true;
    if ($value['startDate'] !== '' && $value['expireDate'] !== '') {
      $currentTime = strtotime(date("Y-m-d"));
      $temp_startTime = strtotime($value['startDate']);
      $temp_endTime = strtotime($value['expireDate']);
      
      if($currentTime > $temp_endTime || $currentTime < $temp_startTime) {
        print_r($value['uuid'])."\n";
      }
    }
  }


  require_once dirname(dirname(__FILE__))."/lib/PHPMailer/PHPMailer.php";
  require_once dirname(dirname(__FILE__))."/lib/PHPMailer/SMTP.php";
  require_once dirname(dirname(__FILE__))."/lib/PHPMailer/Exception.php";

  // $mail = new PHPMailer();

  // $mail->isSMTP();
  // $mail->Host = "smtp.gmail.com";
  // $mail->SMTPAuth = true;
  // $mail->Username = "tomcruihao@gmail.com";
  // $mail->Password = "";
  // $mail->Port = "587";
  // $mail->SMTPSecure = "TLS";

  // // email Settings
  // $mail->isHTML(true);
  // $mail->setFrom("tomcruihao@gmail.com", "Jay");
  // $mail->addAddress("chchang@ebsco.com", "chchang");
  // $mail->Subject = "Test Subject";
  // $mail->Body = "Test Body";

  // if ($mail->send()) {
  //   echo "mail is sent";
  // } else {
  //   echo "Nope";
  //   echo $mail->ErrorInfo;
  // }

  // exit(json_encode(array("response" => $response)));
?>
