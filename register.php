<?php
  $page_title = 'Register';
  require_once("header.php");

  if (!is_logged_in()) {
    include('templates/register.php');
  } else {
    header("location: index.php");
  }
  require_once("footer.php");
?>