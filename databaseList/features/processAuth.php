<?php
  include '_header.php';
  include 'verifyToken.php';
  include '_response.php';

  $jsonFile_direct = '../data/authList.json';

  // parameters
  $type = $_POST["type"];
  $receivedData = json_decode($_POST["processData"], true);

  // get news list
  $getLatestNewsJsonData = file_get_contents($jsonFile_direct);
  $authData = json_decode($getLatestNewsJsonData, true);

  if ($type === 'updateSetting') {
    $authData['settings'] = $receivedData;

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($authData, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  } else if ($type === 'updateList') {
    $authData['department'] = $receivedData['department'];
    $authData['identity'] = $receivedData['identity'];

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($authData, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  }


  function response($errorType, $message) {
    $res = array('status' => $errorType, 'type' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }

  // uuid V4
  function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }
?>
