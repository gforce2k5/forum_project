<?php
  require_once('settings.php');
  if (isset($_GET['hash']) && isset($_GET['id'])) {
    $hash = mysqli_real_escape_string($link, $_GET['hash']);
    $id = mysqli_real_escape_string($link, $_GET['id']);

    $sql = new SQL($link, "UPDATE users SET hash = NULL, status = 1 WHERE id = '$id' AND ".
      "hash = '$hash' AND register_date > '{sql_time(time() - 24 * 60 * 60)}' LIMIT 1");
    print_array($sql);
  }
  header("location:../index.php");
?>