<?php
  require_once("functions/settings.php");
  include ("templates/header.php");

  if (isset($_SESSION['errors'])) {
    $errors = unserialize($_SESSION['errors']);
    foreach ($errror as $error_name => $error_msg) {
      include ("template/error.php");
    }

    unset($_SESSION['errors']);
  }
?>