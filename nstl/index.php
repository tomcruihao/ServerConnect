<?php
  // get parameter from URL
  if(isset($_GET["DOI"]) || isset($_GET["title"])) {
    $DOI = ( isset($_GET["DOI"]) && trim($_GET["id"]) == 'link1' );
    $title = $_GET['title'];
  } else {
    echo "Sorry, can not reached this page, please contact 'support@ebsco.com'";
  }
?>