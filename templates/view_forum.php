<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><?= $cat_name ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= sanitize_input($forum->get_name()) ?></li>
  </ol>
</nav>

<h3 class="text-right"><?= sanitize_input($forum->get_name()) ?></h3>
<?php if ($forum->is_active() && is_logged_in()) { ?>
  <div class="text-right">
    <a data-toggle="modal" data-target="#create-post-modal" class="btn btn-primary" href="#">נושא חדש</a>
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