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
  $resource = json_decode($_POST["resource"], true);

  // get resource list
  $getResourceListJsonData = file_get_contents('../data/eResourceList.json');
  $resourceList = json_decode($getResourceListJsonData, true);

  if ($type === 'add') {
    // get the latest ID and add in resource list
    $latestResource = end($resourceList['rows']);
    $newItemID = strval($latestResource['id']) + 1;
    $resource['id'] = $newItemID;

    // get stroke and zhuyin info
    $getStroke = getStrokeInfo($resource['resourceName']);
    $resource['stroke'] = $getStroke['strokes'];
    $resource['zhuyin'] = $getStroke['zhuyin'];

    array_push($resourceList['rows'], $resource);

    // update resource info
    $total = count($resourceList['rows']);
    $resourceList['total'] = $total;
    $resourceList['totalNotFiltered'] = $total;

    // write back
    file_put_contents('../data/eResourceList.json', json_encode($resourceList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if($type === 'modify') {
    foreach($resourceList['rows'] as $key => $row) {
      if(strcasecmp($row['id'], $resource['id']) == 0) {
        // get stroke and zhuyin info
        $getStroke = getStrokeInfo($resource['resourceName']);

        $resourceList['rows'][$key] = $resource;
        $resourceList['rows'][$key]['stroke'] = $getStroke['strokes'];
        $resourceList['rows'][$key]['zhuyin'] = $getStroke['zhuyin'];
        break;
      }
    }

    // write back
    file_put_contents('../data/eResourceList.json', json_encode($resourceList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else if ($type === 'delete') {
    foreach($resourceList['rows'] as $key => $row) {
      if(strcasecmp($row['id'], $resource['id']) == 0) {
        // unset($resourceList['rows'][$key]);
        array_splice($resourceList['rows'], $key, 1);
        break;
      }
    }

    // write back
    file_put_contents('../data/eResourceList.json', json_encode($resourceList, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  }

  function getStrokeInfo($str_resourName) {
    $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
    $strokes = json_decode($getStrokesJsonData, true);

    // get first char
    $chars = preg_split('/(?<!^)(?!$)/u', $str_resourName);
    $firstChar = $chars[0];
    $result = [];

    foreach($strokes as $stroke) {
      if(strcasecmp($firstChar, $stroke['char']) == 0) {
        $result = $stroke;
        break;
      }
    }

    return $result;
  }

  function response($errorType, $message) {
    $res = array('type' => $errorType, 'mesage' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
