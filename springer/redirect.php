<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset=utf-8");

  $springerOpenUrl = 'http://link.springer.com/openurl?genre=book&isbn=';

  $isbn = $_GET['isbn'];
  $postProcess_isbn = process_isbn(strval($isbn));

  header("Location: ".$springerOpenUrl.$postProcess_isbn);
  die();

  function process_isbn($isbn) {
    // 3-1-3-5-1
    $temp = substr_replace($isbn, '-', 12, 0);
    $temp = substr_replace($temp, '-', 7, 0);
    $temp = substr_replace($temp, '-', 4, 0);
    $temp = substr_replace($temp, '-', 3, 0);

    return $temp;
  }
?>