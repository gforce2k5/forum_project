<?php
  $sql = new SQL($link, "SELECT * FROM categories ORDER BY cat_order ASC");

?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active"><i class="fas fa-home"></i> עמוד הבית</li>
  </ol>
</nav>
<?php
  while ($cat = $sql->result()) {
    $cat = Category::category_from_sql($cat);
    include "templates/category.php";
  }
?>