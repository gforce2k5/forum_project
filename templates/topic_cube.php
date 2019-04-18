<div class="row <?= $classes[$counter] ?>">
  <div class="col-6 text-right">
    <strong><a class="<?= explode(' ', $classes[$counter])[1] ?>" href="view_topic.php?p=<?= $topic->getId() ?>"><?= $topic->isPinned() ? '<i class="fas fa-thumbtack"></i> ' : '' ?><?= $topic->isLocked() ? '<i class="fas fa-lock"></i> ' : '' ?><?= sanitize_input($topic->getTitle()) ?></a></strong>
    <p>על ידי <strong><?= sanitize_input($author) ?></strong> בתאריך <?= format_time($topic->getCreationTime()) ?></p>
  </div>
  <div class="col-2 text-center"><?= $post_count ?></div>
  <div class="col-4 text-right">
    <?php if ($last_post_sql->rows() > 0) { ?>
      <strong><a class="<?= explode(' ', $classes[$counter])[1] ?>" href="view_topic.php?p=<?= $topic->getId() ?>#<?= $last_post['id'] ?>"><?= sanitize_input($last_post['title']) ?></a></strong><br />
      נכתבה בתאריך <?= format_time($last_reply_time) ?> על ידי <strong><?= sanitize_input($last_username) ?></strong>
    <?php } ?>
  </div>
</div>