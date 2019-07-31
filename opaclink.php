<?php
  // get parameter from URL
  $marcNum = $_GET['marc'];
  
  // set parameter
  $appID = 'eds'
  $appKey = 'z18gEZ0bzPMeGpai'
  $connectingUrl = 'http://opac.lib.nankai.edu.cn/api/itemgo.php'


  $timestamp = getCurrentTime();
  echo timestamp
  $stringBinding = marcNum.timestamp.appKey;

  // const sign = md5(stringBinding);
  // return `${connectUrl}?marc_no=${marcNum}&appid=${appID}&time=${timestamp}&sign=${sign}`;

  function getCurrentTime() {
    $currentTime = time();
    return date("d-m-Y h:i:s", $currentTime);
  }
?>
