<?php
  require_once('settings.php');
  if ($_GET['hash']) {
    $hash = mysqli_real_escape_string($link, $_POST['hash']);
    $sql = new SQL($link, "SELECT id FROM users WHERE hash = $hash LIMIT 1");

    if ($sql->ok()) {
      $id = $sql->result();
      $sql = new SQL($link, "UPDATE users SET hash = NULL, is_verified = 1 WHERE id = '$id' LIMIT 1");

      if ($sql->ok()) {
        echo 'You Are Verified';
      }
    }
  }
?>