<?php
  include '_header.php';
  include '_response.php';

  // /databaseList/csvFiles/exportResources.txt
  $jsonFile_direct = '../data/eResourceList.json';
  $txtFilePath = receivedFileAndGetPath();

  // get data from file
  $fileData = remove_utf8_bom(file_get_contents($txtFilePath));
  $fileData = str_replace("\r", '', $fileData);
  $rows = explode("\n", $fileData);
  $resourceKeys = explode("\t", $rows[0]);

  // remove metadata from resources
  unset($rows[0]);

  // create an array to store the databases
  $resourceList = [];

  foreach($rows as $row_key => $row_val) {
    if ($rows[$row_key] !== '') {
      $array_temp = [];
      $resourceContent = explode("\t", $rows[$row_key]);

      foreach($resourceContent as $index => $resourceContent_val) {
        $array_temp[$resourceKeys[$index]] = str_replace('"', '', $resourceContent_val);
      }

      array_push($resourceList, $array_temp);
    }
  }

  foreach($resourceList as $key_resource => $resource) {
    // gen UUID
    if (array_key_exists('uuid', $resourceList[$key_resource])) {
      if(empty($resourceList[$key_resource]['uuid'])) {
        $resourceList[$key_resource]['uuid'] = gen_uuid();
      }
    } else {
      $resourceList[$key_resource]['uuid'] = gen_uuid();
    }
    // if(strcmp($resourceList[$key_resource]['isProxy'], "是") === 0) {
    //   $resourceList[$key_resource]['isProxy'] = true;
    // } else if(strcmp($resourceList[$key_resource]['isProxy'], "否") === 0) {
    //   $resourceList[$key_resource]['isProxy'] = false;
    // }

    // find all language
    $tempAry = [];
    foreach($resource as $key_r => $row) {
      if (strpos($key_r, '__')) {
        $array_language = explode("__",$key_r);
        $tempAry[$array_language[0]][$array_language[1]] = $row;
        unset($resourceList[$key_resource][$key_r]);
      }
    }

    foreach($tempAry as $t_key => $t_row) {
      $resourceList[$key_resource][$t_key] = $t_row;
    }
  }

  // backup the original data
  $currentTime = date("Y_m_d H:i:s");
  if(!is_dir('../backup')){
    // Directory does not exist, so lets create it.
    mkdir('../backup', 0755, true);
  }
  copy($jsonFile_direct, '../backup/'.$currentTime.'.json');

  // write back
  if(is_writable($jsonFile_direct)) {
    file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));
  } else {
    responseError(1001);
  }

  sleep(2);

  generateStrokes();

  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);

  function receivedFileAndGetPath() {
    if ( 0 < $_FILES['file']['error'] ) {
      return false;
    } else {
      move_uploaded_file($_FILES['file']['tmp_name'], '../csvFiles/' . $_FILES['file']['name']);
      return '../csvFiles/'.$_FILES['file']['name'];
    }
  }

  function generateStrokes() {
    $jsonFile_resource_direct = '../data/eResourceList.json';
    $jsonFile_strokes_direct = '../data/strokeList.json';

    // get resource list
    $getResourceListJsonData = file_get_contents($jsonFile_resource_direct);
    $resourceList = json_decode($getResourceListJsonData, true);

    $getStrokesJsonData = file_get_contents('../data/UniHanO.json');
    $strokes = json_decode($getStrokesJsonData, true);

    // for local
    foreach($resourceList as $key_lang => $resource) {
      $chars = preg_split('/(?<!^)(?!$)/u', $resource['local']['resourceName']);
      $firstChar = $chars[0];
      $resultExist = false;
      foreach($strokes as $stroke) {
        if(strcasecmp($firstChar, $stroke['char']) == 0) {
          $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
          $firstZhuyin = $zhuyin[0];
          $resourceList[$key_lang]['local']['zhuyin'] = $firstZhuyin;
          $resourceList[$key_lang]['local']['englishAlphabet'] = '';

          if(strlen(strval($stroke['strokes'])) < 2) {
            $resourceList[$key_lang]['local']['strokes'] = '0'.$stroke['strokes'];
          } else {
            $resourceList[$key_lang]['local']['strokes'] = $stroke['strokes'];
          }

          $resultExist = true;
          break;
        }

        if(!$resultExist) {
          $resourceList[$key_lang]['local']['englishAlphabet'] = $firstChar;
          $resourceList[$key_lang]['local']['zhuyin'] = '';
          $resourceList[$key_lang]['local']['strokes'] = '0';
        }
      }
    }

    // for en
    $alphas = array_merge(range('A', 'Z'), range('a', 'z'));
    foreach($resourceList as $key_lang => $resource) {
      $chars = preg_split('/(?<!^)(?!$)/u', $resource['en']['resourceName']);
      $firstChar = $chars[0];

      if(!in_array($firstChar, $alphas, TRUE)) {
        $firstChar = '';
      }

      $resourceList[$key_lang]['en']['englishAlphabet'] = $firstChar;
      $resourceList[$key_lang]['en']['zhuyin'] = '';
      $resourceList[$key_lang]['en']['strokes'] = '0';
    }

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_resource_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));
    } else {
      responseError(1001);
    }

    // sleep 3sec
    sleep(3);

    ////////////////////////////// generate the alphabet list ///////////////////////////////////////

    // get resource list
    $getNewResourceListJsonData = file_get_contents($jsonFile_resource_direct);
    $newResourceList = json_decode($getNewResourceListJsonData, true);

    $allZhuYin = 'ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄧㄨㄩㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦ';
    $allEnglishAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $zhuYins = preg_split('/(?<!^)(?!$)/u', $allZhuYin);
    $englishAlphabets = str_split($allEnglishAlphabet);
    $zhuyin_map = [];
    $englishAlphabet_en_map = [];
    $englishAlphabet_local_map = [];
    $strokes_map = [];

    // init map
    foreach($zhuYins as $key => $row) {
      $zhuyin_map[$row] = false;
    }

    foreach($englishAlphabets as $key => $row) {
      $englishAlphabet_en_map[$row] = false;
      $englishAlphabet_local_map[$row] = false;
    }

    for($loop = 1; $loop < 50; $loop++) {
      if($loop < 10) {
        $strokes_map['0'.strval($loop)] = false;
      } else {
        $strokes_map[strval($loop)] = false;
      }
    }

    // match with the local map
    // The current Time is to check the expiry date of eResource
    $currentTime = strtotime(date("Y-m-d"));

    foreach($newResourceList as $key_lang => $row) {
      $isInExpiryDate = true;

      if (!filter_var($row['expiredChecking'], FILTER_VALIDATE_BOOLEAN) && $row['startDate'] !== '' && $row['expireDate'] !== '') {
        $temp_startTime = strtotime($row['startDate']);
        $temp_endTime = strtotime($row['expireDate']);

        if($currentTime > $temp_endTime || $currentTime < $temp_startTime) {
          $isInExpiryDate = false;
        }
      }

      // add the stroke, zhuyin in list
      if($isInExpiryDate) {
        // match with the local map
        if(!empty(trim($row['local']['zhuyin']))) {
          $zhuyin_map[$row['local']['zhuyin']] = true;
        }

        if(preg_match("/^[a-zA-Z]$/", $row['local']['englishAlphabet'])) {
          $char_uppercase = strtoupper($row['local']['englishAlphabet']);
          $englishAlphabet_local_map[$char_uppercase] = true;
        }

        if($row['local']['strokes'] !== '0') {
          $strokes_map[$row['local']['strokes']] = true;
        }

        // match with the en map
        if(preg_match("/^[a-zA-Z]$/", $row['en']['englishAlphabet'])) {
          $char_uppercase = strtoupper($row['en']['englishAlphabet']);
          $englishAlphabet_en_map[$char_uppercase] = true;
        }
      }
    }

    // create the list
    $result = [];
    $result['local']['zhuyin'] = [];
    $result['local']['englishAlphabet'] = [];
    $result['local']['strokes'] = [];
    $result['en']['englishAlphabet'] = [];

    foreach($zhuyin_map as $key => $row) {
      if($row) {
        array_push($result['local']['zhuyin'], $key);
      }
    }

    foreach($englishAlphabet_local_map as $key => $row) {
      if($row) {
        array_push($result['local']['englishAlphabet'], $key);
      }
    }

    foreach($strokes_map as $key => $row) {
      if($row) {
        array_push($result['local']['strokes'], $key);
      }
    }

    foreach($englishAlphabet_en_map as $key => $row) {
      if($row) {
        array_push($result['en']['englishAlphabet'], $key);
      }
    }

    // write back
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_strokes_direct, json_encode($result, JSON_UNESCAPED_UNICODE));
    } else {
      responseError(1001);
    }
  }

  function remove_utf8_bom($text) {
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);
    return $text;
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
