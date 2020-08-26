<?php
  // Server setting: crontab -e

  include '_header.php';

  $jsonFilePath_eResource = dirname(dirname(__FILE__)).'/data/eResourceList.json';
  $jsonFilePath_expirySetting = dirname(dirname(__FILE__)).'/data/expiryCheckSetting.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFilePath_eResource);
  $resourceList = json_decode($getResourceListJsonData, true);

  // get setting info
  $getExpirySettings = file_get_contents($jsonFilePath_expirySetting);
  $expirySettingInfo = json_decode($getExpirySettings, true);
  $daysBeforeExpiry = $expirySettingInfo['settings']['daysBeforeExpiry'];

  $result = [];
  $currentTime = new DateTime('now');

  if($expirySettingInfo['settings']['notification_enabled'] == 'true') {
    foreach($resourceList as $key => $value) {
      $expired = true;
  
      // check attribute 'stopCheckingExpiring' exist or not
      if (!array_key_exists('stopCheckingExpiring', $value)) {
        $value['stopCheckingExpiring'] = false;
      }
  
      if (!filter_var($value['stopCheckingExpiring'], FILTER_VALIDATE_BOOLEAN) && trim($value['expireDate']) !== '') {
        $processEndTime = str_replace('/', '-', $value['expireDate']);
        $temp_endTime = new DateTime($processEndTime);
        $temp_startTime = new DateTime($processEndTime);
        $temp_startTime->modify( '-'.$daysBeforeExpiry.' day' );
  
        $tempResult = '';
        $tempResult = check_in_range($temp_startTime, $temp_endTime, $currentTime);
  
        if($tempResult == 'expired') {
          $value['expiredStatus'] = 'expired';
          array_push($result, $value);
        } else if($tempResult == 'expiring') {
          $value['expiredStatus'] = 'expiring';
          array_push($result, $value);
        }
  
        // if($currentTime > $temp_endTime || $currentTime < $temp_startTime) {
        //   $tempArray = array(
        //     "uuid" => $value['uuid'],
        //     "startDate" => $value['startDate'],
        //     "expireDate" => $value['expireDate']
        //   );
        //   array_push($result, $value['uuid']);
        // }
      }
    }
  }
  
  echo json_encode(array("resourceList" => $result));


  function check_in_range($start_date, $end_date, $currentTime) {
    // Convert to timestamp
    // $start_ts = strtotime($start_date);
    // $end_ts = strtotime($end_date);
    // $current_ts = strtotime($currentTime);

    // echo date_format($start_date, 'Y-m-d H:i:s');
    // echo date_format($end_date, 'Y-m-d H:i:s');
    // echo date_format($currentTime, 'Y-m-d H:i:s');
    // echo '###1. '.($currentTime > $end_date);
    // echo '###2. '.($end_date > $currentTime);
    // echo '###3. '.($currentTime > $start_date);
    // echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@';

    if($currentTime > $end_date) {
      return 'expired';
    } else if($end_date > $currentTime && $currentTime > $start_date){
      return 'expiring';
    } else {
      return '';
    }
  }

?>
