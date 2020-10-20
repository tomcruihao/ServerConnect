<?php
  $keyword = $_GET["keyword"];

  // convert param to UTF-8
  $convertedkeyword = mb_convert_encoding($keyword, "UTF-8", "BIG5");
  
  header('Location: index.php?keyword='.$convertedkeyword);
?>