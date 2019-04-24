<?php
  require_once "../functions/settings.php";
  if (is_logged_in() && $current_user->get_status() == 2) {
    $fid = null;
    if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
      $fid = intval($_GET['fid']);
    }

    echo User::get_active_users($link, $fid);
  }
?>