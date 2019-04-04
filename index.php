<?php
  $page_title = 'Forum index';
  require_once("header.php");

  if (!is_logged_in()) {
    include('templates/login.php');
  } else {
    echo '<a href="functions/logout.php">Logout</a>';
  }

  $sql = new SQL($link, "SELECT * FROM categories ORDER BY cat_order ASC");
  
  while ($cat = $sql->result()) {
    $cat = Category::category_from_sql($cat);
    include "templates/category.php";
  }

  require_once("footer.php");
?>