<!DOCTYPE html>
<html>
<head>
  <title>Slick Playground</title>
  <meta charset="UTF-8">
  </head>
<body>
<?php
  $base64Code = $_POST['code'];
  $pageCode = base64_decode($base64Code);
  echo $pageCode;
?>
</body>
</html>