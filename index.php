<?php
  require_once("header.php");
  if (!is_logged_in()) {
?>
    <form action="functions/login.php" method="post">
      <input type="text" name="username" placeholder="username">
      <input type="password" name="password" placeholder="password">
      <input type="checkbox" name="rememver">
      <input type="submit">
    </form>
<?php
  }
  require_once("footer.php");
?>