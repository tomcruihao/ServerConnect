<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');
  date_default_timezone_set('Asia/Taipei');

  $jsonFile_direct = '../data/latestNews.json';

  // parameters
  $type = $_POST["type"];
  // $resource = $_POST["resource"];
  $receivedData = json_decode($_POST["processData"], true);

  // get news list
  $getLatestNewsJsonData = file_get_contents($jsonFile_direct);
  $latestNewsData = json_decode($getLatestNewsJsonData, true);

  if ($type === 'addNews') {
    // generate uuid
    $newItemID = gen_uuid();
    $receivedData['uuid'] = $newItemID;

    // get date
    $receivedData['publishDate'] = date("Y-m-d");

    array_push($latestNewsData['newsList'], $receivedData);

    // write back
    // file_put_contents($jsonFile_direct, json_encode($latestNewsData, JSON_UNESCAPED_UNICODE));
    // response('success', 'success');

  } else if($type === 'updateNews') {
    // search the news
    foreach($latestNewsData['newsList'] as $key => $row) {
      if(strcasecmp($row['uuid'], $receivedData['uuid']) == 0) {
        $latestNewsData['newsList'][$key] = $receivedData;
        break;
      }
    }

    // write back
    file_put_contents($jsonFile_direct, json_encode($latestNewsData, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if ($type === 'deleteNews') {
    foreach($latestNewsData['newsList'] as $key => $row) {
      if(strcasecmp($row['uuid'], $receivedData['uuid']) == 0) {
        // unset($latestNewsData['newsList'][$key]);
        array_splice($latestNewsData['newsList'], $key, 1);
        break;
      }
    }

    // write back
    file_put_contents($jsonFile_direct, json_encode($latestNewsData, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if($type === 'updateNewsField') {
    $latestNewsData['bulletinTitle'] = $receivedData['bulletinTitle'];
    $latestNewsData['displayNumber'] = $receivedData['displayNumber'];

    // write back
    file_put_contents($jsonFile_direct, json_encode($latestNewsData, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  }


  function response($errorType, $message) {
    $res = array('type' => $errorType, 'mesage' => $message);
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
