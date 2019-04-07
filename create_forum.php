<?php
  $page_title = "Create Forum";
  require_once "header.php";
  $error_msg = '';
  $errors = [];
  if (is_logged_in()) {
    if ($current_user->get_status() == 2) {
      $action = 'create';
      include("templates/forum_form.php");
    } else {
      $error_msg = 'אין לך גישה לעמוד זה <a href="./">לחץ כאן לחזרה לעמוד הראשי</a>';
    }
  } else {
    $error_msg = 'אתה לא מחובר <a href="./">לחץ כאן לחזרה לעמוד הראשי</a>';
    $alert_type = 'danger';
    include("templates/alert.php");
  }
  require_once "footer.php";
?>