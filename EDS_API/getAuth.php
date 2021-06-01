<?php
  date_default_timezone_set('Asia/Taipei');

  // variables
  $sessionFilePath = 'sessionInfo.json';
  $uidAuthInfo = '';
  $sessionTimeOut_minute = 30;

  // API Info
  $userInfo = array(
    'UserName' => '',
    'Password' => '',
    'Profile' => 'api',
  );

  // get the auth info
  $ary_sessionData = json_decode(file_get_contents($sessionFilePath), true);

  // check the uid auth info
  if(array_key_exists('AuthenticationToken', $ary_sessionData)) {
    $sessionAlive = checkSessionAlive($sessionData['receivedTime']);
    if(!$sessionAlive) {
      $ary_sessionData = authorizeAndUpadteSessionFile($userInfo, $sessionFilePath);
    }
  } else {
    $ary_sessionData = authorizeAndUpadteSessionFile($userInfo, $sessionFilePath);
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

  function checkSessionAlive($receivedTime) {
    // get current time and transfer the type
    $sessionTimeOut_sec = $GLOBALS['sessionTimeOut_minute'] * 60;
    $string_now = date("Y-m-d H:i:s");
    $time_now = strtotime($string_now);

    $time_receivedTime = strtotime($receivedTime);

    // true means alive
    return ($time_now - $time_receivedTime) > $sessionTimeOut_sec ? false : true;
  }

  function authorizeAndUpadteSessionFile($userInfo) {
    $result = [];

    // get auth result from API server
    $authInfo = json_decode(CallAPI("POST", "https://eds-api.ebscohost.com/Console/IntegratedAuthentication/ValidateUser", $userInfo), true);

    if($authInfo['IsSuccessful']) {
      $result['AuthenticationToken'] = $authInfo['AuthenticationToken'];
      $result['SessionToken'] = $authInfo['SessionToken'];

      // generate received time
      $receivedTime = date("Y-m-d H:i:s");
      $result['receivedTime'] = $receivedTime;

      // update the session file
      file_put_contents($GLOBALS['sessionFilePath'], json_encode($result, JSON_UNESCAPED_UNICODE));
    } else {
      $result = false;
    }

    return $result;
  }
?>
