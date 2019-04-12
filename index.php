<?php
  $page_title = 'Forum index';
  require_once("header.php");

  $sql = new SQL($link, "SELECT * FROM categories ORDER BY cat_order ASC");

?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">עמוד הבית</li>
  </ol>
</nav>
<?php
  while ($cat = $sql->result()) {
    $cat = Category::category_from_sql($cat);
    include "templates/category.php";
  }
  require_once("footer.php");
?>