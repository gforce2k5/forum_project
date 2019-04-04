<?php
  $page_title = "View Forum";
  require_once "header.php";

  if (isset($_GET['f']) && is_numeric($_GET['f'])) {
    $forum_id = intval($_GET['f']);

    
  }

  require_once "footer.php";
?>