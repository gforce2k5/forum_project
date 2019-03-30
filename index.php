<?php
  $page_title = 'Forum index';
  require_once("header.php");

  if (!is_logged_in()) {
    include('templates/login.php');
  } else {
    echo '<a href="functions/logout.php">Logout</a>';
  }
  require_once("footer.php");
?>