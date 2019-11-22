<?php
  $base64Code = $_POST['code'];
  echo 'test'.$base64Code;
  $pageCode = base64_decode($base64Code);
  echo $pageCode;
?>