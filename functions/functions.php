<?php
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function add_error($error_name, $error_message, $error_array) {
    $error_array[$error_name] = $error_message;
    return $error_array;
  }

  function send_verification_email($hash, $email) {
    $msg = "to verify your email click the following link.\nhttp://localhost/functions/verify.php?hash=$hash";
    $subject = "Forum verification email";
    $headers = "From: guy@localhost";

    mail($email, $subject, $headers);
  }

  function is_logged_in() {
    if (isset($_SESSION['is_logged_in']) && isset($_SESSION['sessionid']) && isset($_SESSION['user'])) {
      return $_SESSION['is_logged_in'] &&
        password_verify($_SESSION['sessionid'], unserialize($_SESSION['user'])->get_session_id());
    }
    return false;
  }

  function password_is_hash($password) {
    $nfo = password_get_info($password);
    return $nfo['algo'] != 0;
  }
?>