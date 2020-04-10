<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $html = file_get_contents('https://catalog.xmu.edu.cn/opac/ajax_item.php?marc_no=0002119361');
  echo $html;
?>