<div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
  <?= sanitize_input($error_msg) ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>