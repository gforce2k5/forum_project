<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i> עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><i class="fas fa-circle-notch"></i> <?= $cat_name ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-info-circle"></i> <?= sanitize_input($forum->get_name()) ?></li>
  </ol>
</nav>

<h3 class="text-right"><?= sanitize_input($forum->get_name()) ?></h3>
<?php if (is_logged_in() && ($forum->is_active() || $current_user->get_status() == 2 || $current_user->is_manager($link, $forum->get_id()))) { ?>
  <div class="text-right">
    <a data-toggle="modal" data-target="#create-post-modal" class="btn btn-primary" href="#"><i class="fas fa-sticky-note"></i> נושא חדש</a>
  </div>
<?php
    $action = 'create';
    $parent = 'f';
    $parent_id = $forum->get_id();
    include "templates/post_form.php";
  }
?>
<?= $forum->show_posts($link, true) ?>

<?= $forum->show_posts($link) ?>