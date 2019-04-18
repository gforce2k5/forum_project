<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i> עמוד הבית</a></li>
      <li class="breadcrumb-item active"><i class="fas fa-circle-notch"></i> <?= $cat->get_name() ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-12 text-right">
      <h3><?= $cat->get_name() ?></h3>
    </div>
  </div>
  <?php include "category.php" ?>