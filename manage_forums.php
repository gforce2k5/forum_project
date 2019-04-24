<?php
  $page_title = "ניהול פורומים";
  require_once "functions/settings.php";
  if (!is_logged_in() || $current_user->get_status() != 2) {
    header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : './'));
  }

  include "header.php";
  include "templates/admin.php";
  include "templates/delete_forum_form.php";
  $additional_scripts = '<script src="assets/js/admin.js"></script>';
  include "footer.php";
?>