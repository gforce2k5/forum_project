<?php
  require_once('settings.php');
  if (isset($_GET['hash'])) {
    $hash = mysqli_real_escape_string($link, $_GET['hash']);
    $sql = new SQL($link, "SELECT id FROM users WHERE hash = '$hash' AND registr_date > {time() - 24 * 60 * 60} LIMIT 1");

    if ($sql->rows() >= 1) {
      $id = $sql->result()['id'];
      $sql = new SQL($link, "UPDATE users SET hash = NULL, is_verified = 1 WHERE id = '$id' LIMIT 1");

      if ($sql->is_ok()) {
        echo 'You Are Verified';
      }
    } else {
      header("location:../index.php");
    }
  }
?>