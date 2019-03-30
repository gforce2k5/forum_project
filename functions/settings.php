<?php
  define ('SITE_ROOT', realpath(dirname(__FILE__)));
  require_once(SITE_ROOT."/../classes/class.Cookie.php");
  // require_once(SITE_ROOT."../classes/class.SessionManager.php");
  require_once(SITE_ROOT."/../classes/class.User.php");
  require_once(SITE_ROOT."/../classes/class.SQL.php");
  require_once(SITE_ROOT."/user_settings.php");
  require_once(SITE_ROOT."/functions.php");

  $link = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname) or die(mysqli_connect_error($Link));

  session_start();

  $id_cookie = new Cookie('userid', '', 30);
  $password_cookie = new Cookie('sessionid', '', 30);
?>