<?php
  require_once "../functions/settings.php";
  print_array($_POST);
  if (is_logged_in() && $current_user->get_status() == 2) {
    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
      $fid = intval($_POST['fid']);
    }
  } else echo "משתמש לא מורשה";

  if (isset($fid)) {
    $fid = mysqli_real_escape_string($link, $fid);
    $sql = new SQL($link, "SELECT cat_id FROM forums WHERE id = $fid");
    if ($sql->is_ok() && $sql->rows() == 1) {
      $cat_id = $sql->result()['cat_id'];
      $sql = new SQL($link, "SELECT id FROM forums WHERE cat_id = $cat_id");
      if ($sql->is_ok() && $sql->rows() == 1) {
        if ($sql->result()['id'] == $fid)
          $sql = new SQL($link, "DELETE FROM categories WHERE id = $cat_id");
      }

      $sql = new SQL($link, "DELETE FROM forums WHERE id = $fid");
      $sql = new SQL($link, "SELECT id FROM posts WHERE forum_id = $fid");
      while ($pid = $sql->result()['id']) {
        $psql = new SQL($link, "DELETE FROM posts WHERE post_id = $pid");
      }
      $sql = new SQL($link, "DELETE FROM posts WHERE forum_id = $fid");
      $sql = new SQL($link, "DELETE FROM forums WHERE id = $fid");
    }
  }
?>