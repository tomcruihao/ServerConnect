<!DOCTYPE xtml PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
  // get parameter from URL
  $AN = $_GET['AN'];
  $TM = $_GET['time'];
?>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>eBook Preview</title>
  <script>
    function init(){
      var form = document.forms[0];
      form.action = "index.php"
      form.submit();
    }
  </script>
</head>     
<body onload="init();">
  <form id="send" method="post">
<?php
  echo '<input type="hidden" name="AcNu" value="'.$AN.'"/>';
  echo '<input type="hidden" name="CountDown" value="'.$TM.'"/>';
?>
  </form>
</body>
</html>
