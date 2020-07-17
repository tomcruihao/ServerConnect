<?php  
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

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
  }

  $userInfo = array(
    'UserName' => 'K8Rxy$K-GVvfKkakP8Y',
    'Password' => 'Du0@@RHH4h|qt--hOsC',
    'Profile' => 'eds-api',
    'Customer ID' => 'ns265393'
  );

  $apiResponse = CallAPI("POST", "https://eds-api.ebscohost.com/Console/IntegratedAuthentication/ValidateUser", $userInfo);
  $processResponse = json_decode($apiResponse, true);

  if($processResponse['IsSuccessful']) {
    session_start();
    $_SESSION['AuthenticationToken'] = $processResponse['AuthenticationToken'];
    $_SESSION['SessionToken'] = $processResponse['SessionToken'];
  } else {
    exit();
  }
?>
