<?php
  require_once "../functions/settings.php";
  if (is_logged_in() && $current_user->get_status() == 2) {
    if (isset($_POST['categories'])) {
      $categories = json_decode(($_POST['categories']));
      foreach ($categories as $cat_index => $category) {
        $cat_id = mysqli_real_escape_string($link, $category->id);
        if (count($category->forums) == 0) {
          $sql = new SQL($link, "DELETE FROM categories WHERE id = $cat_id");
          continue;
        }
        $cat_order = mysqli_real_escape_string($link, $cat_index);
        $sql = new SQL($link, "UPDATE categories SET cat_order = '$cat_order' WHERE id = $cat_id");
        foreach ($category->forums as $index => $forum) {
          $id = mysqli_real_escape_string($link, $forum->id);
          $order = mysqli_real_escape_string($link, $index);
          $sql = new SQL($link, "UPDATE forums SET cat_order = '$order', cat_id = $cat_id WHERE id = $id");
        }
      }
    }
  }
?>