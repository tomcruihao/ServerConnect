<?php
  include '_header.php';
  include 'verifyToken.php';
  include '_response.php';

  $jsonFile_direct = '../data/settings.json';

  // get setting list
  $getSettingJsonData = file_get_contents($jsonFile_direct);
  $settings = json_decode($getSettingJsonData, true);

  if(isset($_POST['exportContentIncludeHtml'])) {
    $settings['exportContentIncludeHtml'] = $_POST['exportContentIncludeHtml'] === 'true'? true: false;

    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($settings, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  } else {
    // parameters
    $recievedSettings = json_decode($_POST["settings"], true);

    // replace the settings
    $settings = $recievedSettings;

    // write the setting back to the file
    if(is_writable($jsonFile_direct)) {
      file_put_contents($jsonFile_direct, json_encode($settings, JSON_UNESCAPED_UNICODE));
      response('success', 'success');
    } else {
      responseError(1001);
    }
  }

  function response($errorType, $message) {
    $res = array('status' => $errorType, 'type' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
