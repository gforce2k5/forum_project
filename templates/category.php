<div class="row mt-5">
  <div class="col-6 text-right bg-dark">
    <h4>
      <a class="text-light" href="view_category.php?c=<?= $cat->get_id() ?>">
        <?= sanitize_input($cat->get_name()) ?>
      </a>
    </h4>
  </div>
  <div class="col-2 text-center bg-dark text-light"><h4>נושאים</h4></div>
  <div class="col-2 text-center bg-dark text-light"><h4>תגובות</h4></div>
  <div class="col-2 text-center bg-dark text-light"><h4>תגובה אחרונה</h4></div>
  <?php $cat->display_forums($link); ?>
</div>