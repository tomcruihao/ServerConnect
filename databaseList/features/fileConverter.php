<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

  header("Access-Control-Allow-Origin: *");
  header("Content-Security-Policy: upgrade-insecure-requests");
  // header('Content-Type: application/json');
  header('Content-Type: text/html');

  // received the csv data and move to csv folder
  $csvFilePath = "../csvFiles/ResourceListNew.csv";
  // $csvFilePath = receivedFileAndGetPath();

  $handle = fopen($csvFilePath, 'r');
  while (!feof($handle)) {
    $row = fgetcsv($handle, 10240, ';', '"');
    print_r($row);
    // if (empty($headers))
    //   $headers = $row;
    // else if (is_array($row)) {
    //   array_splice($row, count($headers));
    //   $rows[] = array_combine($headers, $row);
    // }
  }
  fclose($handle);


  // transfer to array
  // if($csvFilePath) {
  //   $dataArray = csvToArray($csvFilePath);
  //   print_r($dataArray);
  // }

  function receivedFileAndGetPath() {
    if ( 0 < $_FILES['file']['error'] ) {
      return false;
    } else {
      move_uploaded_file($_FILES['file']['tmp_name'], '../csvFiles/' . $_FILES['file']['name']);
      return '../csvFiles/'.$_FILES['file']['name'];
    }
  }

  function csvToArray($file) {
    $rows = array();
    $headers = array();

    if (file_exists($file) && is_readable($file)) {
      $handle = fopen($file, 'r');
      while (!feof($handle)) {
        $row = fgetcsv($handle, 10240, ';', '"');
        if (empty($headers))
          $headers = $row;
        else if (is_array($row)) {
          array_splice($row, count($headers));
          $rows[] = array_combine($headers, $row);
        }
      }
      fclose($handle);
    } else {
      // throw new Exception($file . ' doesn`t exist or is not readable.');
      return array("error" => "Coordinates are not available");
    }
    return $rows;
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
