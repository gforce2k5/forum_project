<?php
  require_once("/classes/class.Cookie.php");
  require_once("/classes/class.SessionManager.php");
  require_once("/classes/class.User.php");
  require_once("user_settings.php");

  $link = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname) or die(mysqli_connect_error($Link));
?>