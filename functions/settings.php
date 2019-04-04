<?php
  define ('SITE_ROOT', realpath(dirname(__FILE__)));
  require_once(SITE_ROOT."/../classes/class.Cookie.php");
  require_once(SITE_ROOT."/../classes/class.User.php");
  require_once(SITE_ROOT."/../classes/class.Post.php");
  require_once(SITE_ROOT."/../classes/class.Category.php");
  require_once(SITE_ROOT."/../classes/class.Forum.php");
  require_once(SITE_ROOT."/../classes/class.SQL.php");
  require_once(SITE_ROOT."/user_settings.php");
  require_once(SITE_ROOT."/functions.php");

  $link = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname) or die(mysqli_connect_error($Link));

  session_start();

  $id_cookie = new Cookie('userid', '', 30);
  $password_cookie = new Cookie('sessionid', '', 30);
  
  if (!is_logged_in()) {
    if ($id_cookie->exists() && $password_cookie->exists()) {
      $user = User::pull_from_db($link, $id_cookie->get(), true);
      $sessionid = $user->get_session_id(false);
      if (password_verify($sessionid, $password_cookie->get())) {
        $user->login_session($link);
      }
    }
  }
?>