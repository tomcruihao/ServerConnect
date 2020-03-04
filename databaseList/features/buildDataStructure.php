<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  $jsonFile_direct = '../data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $result = [];

  foreach($resourceList['en'] as $key => $value) {
    // $enTemp[$value['uuid']] = $value;
    $stack = array(
      "uuid" => $value['uuid'],
      "resourceUrl" => $value['resourceUrl'],
      "isProxy" => $value['isProxy'],
      "startDate" => $value['startDate'],
      "expireDate" => $value['expireDate'],
      "relevanceUrl" => $value['relevanceUrl'],
      "en" => array(
        "resourceName" => $value['resourceName'],
        "resourceType" => $value['resourceType'],
        "faculty" => $value['faculty'],
        "department" => $value['department'],
        "subject" => $value['subject'],
        "category" => $value['category'],
        "publish" => $value['publish'],
        "language" => $value['language'],
        "resourceDescribe" => $value['resourceDescribe'],
        "relevvanceUrlDescribe" => $value['relevvanceUrlDescribe']
      )
    );
    array_push($result,$stack);
  }
  print_r($result);
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

  // // write back
  // file_put_contents($jsonFile_direct, json_encode($resourceList, JSON_UNESCAPED_UNICODE));

  // $res = array('type' => 'success', 'mesage' => 'success');
  // echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
