<?php
  require_once "../functions/settings.php";

  $result = [];

  if (is_logged_in() && $current_user->get_status() == 2) {
    if (isset($_GET['all']) && $_GET['all'] == 1) {
      $sql = new SQL($link, "SELECT * FROM categories ORDER BY cat_order");
      while ($cat = $sql->result()) {
        $forums = [];
        $forum_sql = new SQL($link, "SELECT id, name, description, create_date, cat_order, active FROM forums WHERE cat_id = {$cat['id']} ORDER BY cat_order");
        while ($forum = $forum_sql->result()) {
          array_push($forums, $forum);
        }
        $cat['forums'] = $forums;
        array_push($result, $cat);
      }
    }
  }

  echo json_encode($result);
?>