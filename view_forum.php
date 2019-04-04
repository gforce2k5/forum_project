<?php
  $page_title = "View Forum";
  require_once "header.php";

  if (isset($_GET['f']) && is_numeric($_GET['f'])) {
    $forum_id = intval($_GET['f']);
    $forum = Forum::from_id($link, $forum_id);
    if ($forum) {
      include "templates/view_forum.php";
    } else {
      $error_msg = 'חלה שגיאה';
      $alert_type = 'warning';
      include "templates/alert.php";
    }
  }

  require_once "footer.php";
?>