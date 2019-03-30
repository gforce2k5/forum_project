<?php
  require_once("settings.php");

  if (is_logged_in()) header("location: ../");

  $username = $password = "";

  if (isset($_POST['Submit']) && $_POST['Submit']) {
    if (isset($_POST['username'])) $username = $_POST['username'];
    if (isset($_POST['password'])) $password = $_POST['password'];

    $user = User::pull_from_db($link, $username);

    if ($user) {
      if (password_verify($password, $user->get_hashed_password())) {
        $hash = $user->get_session_id();
        if (isset($_POST['remember'])) {
          $id_cookie->change($user->get_id());
          $id_cookie->set();
          $password_cookie->change($hash);
          $password_cookie->set();
        }
        $user->login_session($link);
      } else {
        echo "Bad username or password";
      }
    } else {
      echo "Bad username or password";
    }
  }

  header("location: ../");
?>