<?php
  $base64Code = $_GET['code'];
  $pageCode = base64_decode($base64Code);
  echo $pageCode;
?>