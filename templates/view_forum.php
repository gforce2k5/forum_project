<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><?= $cat_name ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= sanitize_input($forum->get_name()) ?></li>
  </ol>
</nav>

<h1><?= sanitize_input($forum->get_name()) ?></h1>
<?= $forum->show_posts($link, true) ?>
<?= $forum->show_posts($link) ?>
<?php if ($forum->is_active()) { ?>
  <a href="create_topic.php?f=<?= $forum->get_id() ?>">נושא חדש</a>
<?php } ?>