<?php
  require_once("settings.php");
  if (is_logged_in()) {
    session_unset();
    session_destroy();

    $id_cookie->unset();
    $password_cookie->unset();
  }

  header("location: ../index.php");
?>