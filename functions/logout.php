<?php
  require_once("settings.php");
  session_unset();
  session_destroy();

  $id_cookie->unset();
  $password_cookie->unset();

  header("location: ../index.php");
?>