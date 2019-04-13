<div class="row">
  <div class="col-6">
    <?php
      if (is_logged_in() && ($current_user->get_status() == 2 || $current_user->get_id() === $author_id)) {
    ?>
        <button class="btn btn-warning">ערוך</button>
    <?php
      }
    ?>
  </div>
  <div class="col-6">
    <?php
      if (is_logged_in() && $current_user->get_status() == 2) {
    ?>
        <button class="btn btn-danger">מחק</button>
    <?php
      }
    ?>
  </div>
</div>