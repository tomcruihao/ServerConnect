<?php
  include '_header.php';

  // $jsonFile_direct = '../data/eResourceList.json';
  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $result = [];

  foreach($resourceList as $key_resource => $resource) {
    // gen UUID
    if (array_key_exists('uuid', $resourceList[$key_resource])) {
      if(empty($resourceList[$key_resource]['uuid'])) {
        $resourceList[$key_resource]['uuid'] = gen_uuid();
      }
    } else {
      $resourceList[$key_resource]['uuid'] = gen_uuid();
    }

    // $resourceList[$key_resource]['uuid'] = gen_uuid();

    if(strcmp($resourceList[$key_resource]['isProxy'], "是") === 0) {
      $resourceList[$key_resource]['isProxy'] = true;
    } else if(strcmp($resourceList[$key_resource]['isProxy'], "否") === 0) {
      $resourceList[$key_resource]['isProxy'] = false;
    }

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

  // foreach($resourceList as $key => $value) {
  //   $resourceList[$key]['local'] = $resourceList[$key]['tw'];
  //   unset($resourceList[$key]['tw']);
  // }
  // print_r($resourceList);

  // foreach($resourceList['en'] as $key => $value) {
  //   // $enTemp[$value['uuid']] = $value;
  //   $stack = array(
  //     "uuid" => $value['uuid'],
  //     "resourceUrl" => $value['resourceUrl'],
  //     "isProxy" => $value['isProxy'],
  //     "startDate" => $value['startDate'],
  //     "expireDate" => $value['expireDate'],
  //     "relevanceUrl" => $value['relevanceUrl'],
  //     "en" => array(
  //       "resourceName" => $value['resourceName'],
  //       "resourceType" => $value['resourceType'],
  //       "faculty" => $value['faculty'],
  //       "department" => $value['department'],
  //       "subject" => $value['subject'],
  //       "category" => $value['category'],
  //       "publish" => $value['publish'],
  //       "language" => $value['language'],
  //       "resourceDescribe" => $value['resourceDescribe'],
  //       "relevvanceUrlDescribe" => $value['relevvanceUrlDescribe']
  //     )
  //   );
  //   array_push($result,$stack);
  // }
  // foreach($result as $key => $value) {
  //   foreach($resourceList['tw'] as $tkey => $tvalue) {
  //     // echo $value['uuid'].' and '.$tvalue['uuid'].'<br>';
  //     if(strcasecmp($value['uuid'], $tvalue['uuid']) == 0) {
  //       $result[$key]['tw'] = array(
  //         "resourceName" => $tvalue['resourceName'],
  //         "resourceType" => $tvalue['resourceType'],
  //         "faculty" => $tvalue['faculty'],
  //         "department" => $tvalue['department'],
  //         "subject" => $tvalue['subject'],
  //         "category" => $tvalue['category'],
  //         "publish" => $tvalue['publish'],
  //         "language" => $tvalue['language'],
  //         "resourceDescribe" => $tvalue['resourceDescribe'],
  //         "relevvanceUrlDescribe" => $tvalue['relevvanceUrlDescribe']
  //       );
  //       // array_push($result[$key],$stack);
  //       break;
  //     }
  //   }
  // }
  // print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
  // foreach($resourceList['tw'] as $key => $value) {
  //   $twTemp[$value['uuid']] = $value;
  // }


  // // 1st foreach loop languages
  // foreach($resourceList as $key_lang => $language) {
  //   foreach($language as $key_r => $row) {
  //     // get first char
  //     $chars = preg_split('/(?<!^)(?!$)/u', $row['resourceName']);
  //     $firstChar = $chars[0];
  //     $resultExist = false;

  //     foreach($strokes as $stroke) {
  //       if(strcasecmp($firstChar, $stroke['char']) == 0) {
  //         $zhuyin = preg_split('/(?<!^)(?!$)/u', $stroke['zhuyin']);
  //         $firstZhuyin = $zhuyin[0];
  //         $resourceList[$key_lang][$key_r]['zhuyin'] = $firstZhuyin;
  //         $resourceList[$key_lang][$key_r]['englishAlphabet'] = '';

  //         if(strlen(strval($stroke['strokes'])) < 2) {
  //           $resourceList[$key_lang][$key_r]['strokes'] = '0'.$stroke['strokes'];
  //         } else {
  //           $resourceList[$key_lang][$key_r]['strokes'] = $stroke['strokes'];
  //         }

  //         $resultExist = true;
  //         break;
  //       }
  //     }

  //     if(!$resultExist) {
  //       $resourceList[$key_lang][$key_r]['englishAlphabet'] = $firstChar;
  //       $resourceList[$key_lang][$key_r]['zhuyin'] = '';
  //       $resourceList[$key_lang][$key_r]['strokes'] = '0';
  //     }
  //   }
  // }

  // write back
  file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  $res = array('status' => 'success', 'type' => 'success');
  echo json_encode($res, JSON_UNESCAPED_UNICODE);

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
