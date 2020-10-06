<?php
  include '_header.php';

  include 'verifyToken.php';

  $jsonFile_direct = '../data/settings.json';

  // get setting list
  $getSettingJsonData = file_get_contents($jsonFile_direct);
  $settings = json_decode($getSettingJsonData, true);

  if(isset($_POST['exportContentIncludeHtml'])) {
    $settings['exportContentIncludeHtml'] = $_POST['exportContentIncludeHtml'] === 'true'? true: false;
    file_put_contents($jsonFile_direct, json_encode($settings, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  } else {
    // parameters
    $recievedSettings = json_decode($_POST["settings"], true);

    // replace the settings
    $settings = $recievedSettings;

    // write the setting back to the file
    file_put_contents($jsonFile_direct, json_encode($settings, JSON_UNESCAPED_UNICODE));
    response('success', 'success');
  }

  function response($errorType, $message) {
    $res = array('status' => $errorType, 'type' => $message);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
  }
?>
