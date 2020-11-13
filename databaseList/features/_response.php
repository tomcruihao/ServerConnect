<?php
  function responseError($codeNumber) {
    $errorMsg = '';

    if($codeNumber > 1000) {
      http_response_code($codeNumber);

      switch ($codeNumber) {
        case 1001:
          $errorMsg = 'Data is not writable';
          break;
        default:
          $errorMsg = 'Exception Code Number: '.$codeNumber;
          break;
      }

      $res = array('errorCode' => $codeNumber, 'errorMesage' => $errorMsg);
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
      exit();
    } else if($codeNumber > 300) {
      http_response_code($codeNumber);
    }
  }
?>
