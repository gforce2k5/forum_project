<?php
  require_once("functions/settings.php");
  include ("templates/header.php");

  if (!is_logged_in()) {
    include('templates/login.php');
  } else {
    echo '<a href="functions/logout.php">Logout</a>';
  }
?>