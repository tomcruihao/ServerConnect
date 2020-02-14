<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $isbn = $_GET['isbn'];
  echo $isbn;
  $postProcess_isbn = process_isbn($isbn);

  function process_isbn($isbn) {
    // 3-1-3-5-1
    $temp = substr_replace($temp, '-', 11, 0);
    $temp = substr_replace($temp, '-', 6, 0);
    $temp = substr_replace($temp, '-', 3, 0);
    $temp = substr_replace($temp, '-', 2, 0);

    echo $temp;
    return $temp;
  }
?>