<?php
  require_once("settings.php");

  if ($id_cookie->exists() && $password_cookie->exists()) {
    $user = User::pull_from_db($link, $id_cookie->get(), true);
    $sessionid = $user->get_session_id(false);
    if (password_verify($password_cookie->get(), $sessionid)) {
      $user->login_session($link);
      header("location: '../index.php'");
    }
  }

  print_array($_POST);

  $username = $password = "";

  if (!is_logged_in()) {
    if (isset($_POST['Submit']) && $_POST['Submit']) {
      if (isset($_POST['username'])) $username = $_POST['username'];
      if (isset($_POST['password'])) $password = $_POST['password'];

      $user = User::pull_from_db($link, $username);

      print_array($user);

      if ($user) {
        if (password_verify($password, $user->get_hashed_password())) {
          echo "You are logged in";
          $hash = $user->get_session_id();
          if (isset($_POST['remember'])) {
            $id_cookie->set();
            $id_cookie->change($user->get_id());
            $password_cookie->set();
            $password_cookie->change($hash);
          }
          $user->login_session($link);
        } else {
          echo "Bad username or password";
        }
      } else {
        echo "Bad username or password";
      }
    }
  }
  header("location:../");
?>