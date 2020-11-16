<?php
  include '_header.php';
  include 'verifyToken.php';
  include '_response.php';

  $jsonFile_direct = '../data/expiryCheckSetting.json';

  // parameters
  $type = $_POST["type"];
  $receivedSetting = $_POST["settings"];

  // get resource list
  $getExpirySettingsJsonData = file_get_contents($jsonFile_direct);
  $expirySettings = json_decode($getExpirySettingsJsonData, true);

  if ($type === 'update') {
    $expirySettings['settings'] = $receivedSetting;

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($expirySettings, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  } else if($type === 'modify') {
    foreach($resourceList as $key => $row) {
      if(strcasecmp($row['uuid'], $resource['uuid']) == 0) {
        // get stroke and zhuyin info
        $getStroke = getStrokeInfo($resource['local']['resourceName'], $resource['en']['resourceName']);

        $resourceList[$key] = $resource;
        $resourceList[$key]['en']['stroke'] = $getStroke['strokes'];
        $resourceList[$key]['en']['zhuyin'] = $getStroke['zhuyin'];
        $resourceList[$key]['en']['englishAlphabet'] = $getStroke['englishAlphabet'];
        $resourceList[$key]['local']['stroke'] = $getStroke['strokes'];
        $resourceList[$key]['local']['zhuyin'] = $getStroke['zhuyin'];
        $resourceList[$key]['local']['englishAlphabet'] = $getStroke['englishAlphabet'];
        break;
      }
    }

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  } else if ($type === 'delete') {
    foreach($resourceList as $key => $row) {
      if(strcasecmp($row['uuid'], $resource['uuid']) == 0) {
        array_splice($resourceList, $key, 1);
        break;
      }
    }

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  }

  function getStrokeInfo($str_resourceName_local, $str_resourceName_en) {
    $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
    $strokes = json_decode($getStrokesJsonData, true);
    $resultExist = false;

    // get first char
    $chars = preg_split('/(?<!^)(?!$)/u', $str_resourceName_local);
    $firstChar = $chars[0];
    $result = [];

    foreach($strokes as $stroke) {
      if(strcasecmp($firstChar, $stroke['char']) == 0) {
        $result = $stroke;
        
        $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
        $firstZhuyin = $zhuyin[0];
        $result['zhuyin'] = $firstZhuyin;

        if(strlen(strval($stroke['strokes'])) < 2) {
          $result['strokes'] = '0'.$stroke['strokes'];
        }
        
        $resultExist = true;
        break;
      }
    }

    if(!$resultExist) {
      $result['zhuyin'] = '';
      $result['strokes'] = '0';
      $result['englishAlphabet'] = $firstChar;
    } else {
      $chars = preg_split('/(?<!^)(?!$)/u', $str_resourceName_en);
      $firstChar = $chars[0];
      $result['englishAlphabet'] = $firstChar;
    }

    return $result;
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

  function response($errorType, $message) {
    $res = array('status' => $errorType, 'type' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
