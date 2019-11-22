<?php
  $base64Code = $_POST['code'];
  $pageCode = base64_decode($base64Code);
  echo $pageCode;
?>