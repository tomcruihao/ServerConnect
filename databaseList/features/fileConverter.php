<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  header('Content-Type: application/json');

  if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    echo "Error";
  }
  else {
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    echo "Success";
  }

// 
// // CSV File
// $filename = 'someExcel.csv';

// // Function - CSV to JSON
// function csvToArray($file) {
//   $rows = array();
//   $headers = array();

//   if (file_exists($file) && is_readable($file)) {
//     $handle = fopen($file, 'r');
//     while (!feof($handle)) {
//       $row = fgetcsv($handle, 10240, ';', '"');
//       if (empty($headers))
//         $headers = $row;
//       else if (is_array($row)) {
//         array_splice($row, count($headers));
//         $rows[] = array_combine($headers, $row);
//       }
//     }
//     fclose($handle);
//   } else {
//     // throw new Exception($file . ' doesn`t exist or is not readable.');
//     return array("error" => "Coordinates are not available");
//   }
//   return $rows;
// }

// $dataArray = csvToArray($filename);

// // Send JSON headers
// header('Cache-Control: no-cache, must-revalidate');
// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
// header('Content-type: application/json; charset=utf-8');

// // Print out JSON
// echo json_encode($dataArray, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n";
?>
