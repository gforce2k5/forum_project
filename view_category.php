<?php
  $page_title = "הצגת קטגוריה";
  require_once "header.php";

  if (isset($_GET['c']) && is_numeric($_GET['c'])) {
    $c_id = intval($_GET['c']);
    $sql = new SQL($link, "SELECT * FROM categories WHERE id = $c_id");
    if ($sql->is_ok()) {
      $cat = Category::category_from_sql($sql->result());
      include_once "templates/view_category.php";
    }
  }
  
  require_once "footer.php";
?>