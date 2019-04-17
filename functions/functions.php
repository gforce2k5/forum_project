<?php
  function add_error($error_name, $error_message, $error_array) {
    $error_array[$error_name] = $error_message;
    return $error_array;
  }

  function sanitize_input($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }

  function send_verification_email($hash, $email) {
    $msg = "to verify your email click the following link.\nhttp://localhost/functions/verify.php?hash=$hash";
    $subject = "Forum verification email";
    $headers = "From: guy@localhost";

    mail($email, $subject, $msg, $headers);
  }

  function is_logged_in() {
    if (isset($_SESSION['is_logged_in']) && isset($_SESSION['sessionid']) && isset($_SESSION['user'])) {
      return $_SESSION['is_logged_in'] &&
        password_verify(unserialize($_SESSION['user'])->get_session_id(false), $_SESSION['sessionid']);
    }
    return false;
  }

  function password_is_hash($password) {
    $nfo = password_get_info($password);
    return $nfo['algo'] != 0;
  }

  function print_array($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
  }

  function display_alerts() {
    if (isset($_SESSION['errors'])) {
      $errors = unserialize($_SESSION['errors']);
      $alert_type = 'danger';
      foreach ($errors as $error => $error_msg) {
        include SITE_ROOT."/../templates/alert.php";
      }
      unset($_SESSION['errors']);
    }

    if (isset($_SESSION['success'])) {
      $alert_type = 'success';
      $error_msg = $_SESSION['success'];
      include SITE_ROOT."/../templates/alert.php";
      unset($_SESSION['success']);
    }
  }

  function sql_time($time) {
    return date('Y-m-d H:i:s', $time);
  }

  function format_time($time) {
    return date('d-m-Y H:i:s', strtotime($time));
  }

  function validate_post($p, $create = true) {
    $errors = [];
    if (!isset($p['title']) || strlen($p['title']) == 0) {
      $errors = add_error('title', 'לא הוכנסה כותרת לפוסט', $errors);
    }
  
    if (!isset($p['content']) || strlen($p['content']) == 0) {
      $errors = add_error('content', 'לא הכנסת תוכן לפוסט', $errors);
    }

    if ($create) {
      if (!isset($p['parent']) || strlen($p['parent']) != 1) {
        $parent = $p['parent'];
        if ($parent != 'f' && $parent != 'p') {
          $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
        }
      } else {
        $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
      }
    
      if (!isset($p['parent_id']) || !is_numeric($p['parent_id'])) {
        $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
      }
    } else {
      if (!isset($p['p_id']) || !is_numeric($p['p_id'])) {
        $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
      }
    }

    return $errors;
  }
?>