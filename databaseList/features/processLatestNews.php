<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  // header("Content-Type:text/html;charset=utf-8");
  header('Content-Type: application/json');

  // parameters
  $type = $_POST["type"];
  // $resource = $_POST["resource"];
  $receivedNews = json_decode($_POST["news"], true);

  // get news list
  $getLatestNewsJsonData = file_get_contents('../data/latestNews.json');
  $latestNewsData = json_decode($getLatestNewsJsonData, true);

  if ($type === 'addNews') {
    // generate uuid
    $newItemID = uniqid();
    $receivedNews['uuid'] = $newItemID;

    // get date
    $receivedNews['publishDate'] = date("Y-m-d");

    array_push($latestNewsData['newsList'], $receivedNews);

    // write back
    file_put_contents('../data/latestNews.json', json_encode($latestNewsData, JSON_UNESCAPED_UNICODE));
    response('success', 'success');

  } else if($type === 'modifyNews') {
    foreach($latestNewsList['newsList'] as $key => $row) {
      if(strcasecmp($row['uuid'], $resource['uuid']) == 0) {
        $latestNewsList['newsList'][$key] = $receivedNews;
        break;
      }
    }

    // write back
    file_put_contents('../data/latestNews.json', json_encode($latestNewsList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if ($type === 'deleteNews') {
    foreach($resourceList['rows'] as $key => $row) {
      if(strcasecmp($row['uuid'], $resource['uuid']) == 0) {
        unset($latestNewsList['newsList'][$key]);
        break;
      }
    }

    // write back
    file_put_contents('../data/latestNews.json', json_encode($latestNewsList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if($type === 'modifyTitle') {

  }


  function response($errorType, $message) {
    $res = array('type' => $errorType, 'mesage' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
