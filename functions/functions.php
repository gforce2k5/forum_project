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
?>