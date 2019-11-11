<?php
  $url = '';

  // get parameter from URL
  if(isset($_GET["DOI"])) {
    $DOI = $_GET['DOI'];
    $url = "http://archive.nstl.gov.cn/Archives/search.do?action=quickSearch&searchText=".$DOI."&dbname=All&searchType=fuzzy&field1=DOI";
    echo "Please wait a moment...";
  } elseif(isset($_GET["Title"])) {
    $title = $_GET['Title'];
    $url = "http://archive.nstl.gov.cn/Archives/search.do?action=quickSearch&searchText=".$title."&dbname=All&searchType=fuzzy&field1=Title";
    echo "Please wait a moment...";
  } else {
    echo "Sorry, can not reached this page, please contact 'support@ebsco.com'";
  }
?>
