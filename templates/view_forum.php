<h1><?= sanitize_input($forum->get_name()) ?></h1>
<?= $forum->show_posts($link, true) ?>
<?= $forum->show_posts($link) ?>
<?php if ($forum->is_active()) { ?>
  <a href="create_topic.php?f=<?= $forum->get_id() ?>">נושא חדש</a>
<?php } ?>