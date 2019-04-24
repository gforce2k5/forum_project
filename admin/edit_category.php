<?php
  require_once "../functions/settings.php";
  if (is_logged_in() && $current_user->get_status() == 2) {
    if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 0) {
      $name = trim($_POST['name']);
    } else {
      echo "שם הקטגוריה לא יכול להישאר ריק";
    }

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
      $id = intval($_POST['id']);
    } else {
      echo "מזהה הקטגוריה חייב להיות מספר";
    }

    if (isset($name) && isset($id)) {
      $name = mysqli_real_escape_string($link, $name);
      $id = mysqli_real_escape_string($link, $id);
      $sql = new SQL($link, "UPDATE categories SET name = '$name' WHERE id = $id");
    }
  }
?>