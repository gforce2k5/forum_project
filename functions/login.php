<?php
  require_once("settings.php");

  $errors = [];

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
        $_SESSION['success'] = "שלום {$user->get_first_name()} התחברת בהצלחה למערכת";
      } else {
        $errors = add_error('login', 'שם משתמש או סיסמא לא נכונים', $errors);
      }
    } else {
      $errors = add_error('login', 'שם משתמש או סיסמא לא נכונים', $errors);
    }
  }

  if (count($errors) > 0 ) {
    $_SESSION['errors'] = serialize($errors);
  }

  header("location: ../");
?>