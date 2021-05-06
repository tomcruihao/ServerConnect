<?php
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://gss.ebscohost.com/");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  $uidAuthFilePath = 'sessionInfo.json';
  $uidAuthInfo = '';
  $sessionTimeOut_min = 30;

  ///////// Template ////////
  // $userInfo = array(
  //   'UserName' => 'wfa6-ukv5ey76v*6yfum',
  //   'Password' => '3J=-.ZjvSILM~-8zr6Hl',
  //   'Profile' => 'api',
  // );

  if(isset($_POST["user"])) {
    $userInfo = json_decode($_POST["user"], true);
  }

  // get the uid auth info
  $uidAuthInfo = auth($userInfo);

  if($uidAuthInfo['IsSuccessful']) {
    session_start();
    $_SESSION['AuthenticationToken'] = $uidAuthInfo['AuthenticationToken'];
    $_SESSION['SessionToken'] = $uidAuthInfo['SessionToken'];

    $response = array('status' => 'success', 'type' => 'account', 'message' => $tokenInfo);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    $response = array('status' => 'error', 'type' => 'account', 'message' => $uidAuthInfo['ErrorMessage']);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }

  function CallAPI($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method) {
      case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data)
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
      case "PUT":
        curl_setopt($curl, CURLOPT_PUT, 1);
        break;
      default:
        if ($data)
          $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
  }

  function checkSessionExiry($receivedTime, $sessionTimeOut_min) {
    // get current time and transfer the type
    $sessionTimeOut_sec = $sessionTimeOut_min * 60;
    $string_now = date("Y-m-d H:i:s");
    $time_now = strtotime($string_now);

    $time_receivedTime = strtotime($receivedTime);

    return ($time_now - $time_receivedTime) > $sessionTimeOut_sec ? true : false;
  }

  function auth($userInfo) {
    $authInfo = json_decode(CallAPI("POST", "https://eds-api.ebscohost.com/Console/IntegratedAuthentication/ValidateUser", $userInfo), true);

    return $authInfo;
  }
?>
