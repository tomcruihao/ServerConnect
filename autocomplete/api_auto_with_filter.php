<?php
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json;charset=UTF-8');
  date_default_timezone_set('Asia/Taipei');

  // UIDAuth parameters
  $json_authInfo = json_encode(array(
    'UserId' => 'UID on EAdmin',
    'Password' => 'PWD on EAdmin',
    'Options' => array('autocomplete')
  ), JSON_UNESCAPED_UNICODE);

  ///////// idx type(Choose the one you want) /////////
  // $idxInfo = '&idx=rawqueries';
  // $idxInfo = '&idx=holdings';
  $idxInfo = '&idx=rawqueries&idx=holdings';

  $uidAuthFilePath = 'sessionInfo.json';
  $uidAuthInfo = '';

  if(isset($_GET['term'])) {
    $term = $_GET['term'];
  }

  // get the uid auth info
  $sessionData = json_decode(file_get_contents($uidAuthFilePath), true);

  // check the uid auth info
  if(array_key_exists('AuthToken', $sessionData)) {
    $sessionExpired = checkSessionExiry($sessionData['receivedTime'], $sessionData['Autocomplete']['TokenTimeOut']);

    if($sessionExpired) {
      $uidAuthInfo = authenAndRecording();
    } else {
      $uidAuthInfo = $sessionData;
    }
  } else {
    $uidAuthInfo = authenAndRecording();
  }

  // get auto-complete result
  $autoComplete_Url = $uidAuthInfo['Autocomplete']['Url'];
  $string_autoComplete_parameters = 'token='.urlencode($uidAuthInfo['Autocomplete']['Token']).'&term='.urlencode($term).$idxInfo.'&format=json'.'&filters='.urlencode(json_encode(array(array('name' => 'custid','values' => array($uidAuthInfo['Autocomplete']['CustId']))), JSON_UNESCAPED_UNICODE));

  $autoCompleteResponse = CallAPI("GET", $autoComplete_Url, $string_autoComplete_parameters);
  $filteredPhrases = filter($autoCompleteResponse);
  echo $filteredPhrases;


  function checkSessionExiry($receivedTime, $tokenTimeOut) {
    // get current time and transfer the type
    $string_now = date("Y-m-d H:i:s");
    $time_now = strtotime($string_now);

    $time_receivedTime = strtotime($receivedTime);

    return intval($tokenTimeOut) - ($time_now - $time_receivedTime) > 0 ? false : true;
  }

  function authenAndRecording() {
    $authInfo = json_decode(CallAPI("POST", "https://eds-api.ebscohost.com/AuthService/rest/UIDAuth", $GLOBALS['json_authInfo']), true);
    $receivedTime = date("Y-m-d H:i:s");
    $authInfo['receivedTime'] = $receivedTime;

    // write the session info in json file
    file_put_contents($GLOBALS['uidAuthFilePath'], json_encode($authInfo, JSON_UNESCAPED_UNICODE));
    return $authInfo;
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
      case "GET":
        if ($data) {
          // $url = sprintf("%s?%s", $url, http_build_query($data));
          $url = sprintf("%s?%s", $url, $data);
        }
        break;
      default:
        if ($data) {
          // $url = sprintf("%s?%s", $url, http_build_query($data));
          $url = sprintf("%s?%s", $url, $data);
        }
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json'));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
  }

  function filter($obj_terms) {
    $blockTerms = array("blkTerm1", "blkTerm1", "blkTerm1");

    $ary_terms = json_decode($obj_terms, true);
    foreach($ary_terms['terms'] as $key => $row) {
      foreach($blockTerms as $blockTerm) {
        if (strpos(strtolower($row['term']), strtolower($blockTerm)) !== false) {
          // echo "Removed";
          // remove this term from array
          unset($ary_terms['terms'][$key]);
        }
      }
    }

    return json_encode($ary_terms, JSON_UNESCAPED_UNICODE);
  }
?>
