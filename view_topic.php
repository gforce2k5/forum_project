<?php
  $page_title = "View Topic";
  require_once "header.php";

  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $topic_id = intval($_GET['p']);
    $topic = Post::from_id($link, $topic_id);
    if ($topic) {
      include "templates/view_topic.php";
    } else {
      $error_msg = 'חלה שגיאה';
      $alert_type = 'warning';
      include "templates/alert.php";
    }
  }

  require_once "footer.php";
?>