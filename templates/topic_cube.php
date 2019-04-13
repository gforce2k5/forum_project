<div class="row <?= $classes[$counter] ?>">
  <div class="col-6 text-right">
    <strong><a class="<?= explode(' ', $classes[$counter])[1] ?>" href="view_topic.php?p=<?= $topic->getId() ?>"><?= htmlspecialchars($topic->getTitle()) ?></a></strong>
    <p>על ידי <strong><?= sanitize_input($author) ?></strong> בתאריך <?= format_time($topic->getCreationTime()) ?></p>
  </div>
  <div class="col-2 text-center"><?= $post_count ?></div>
  <div class="col-4 text-right">
    <?php if ($last_reply_time) { ?>
      נכתבה בתאריך <?= format_time($last_reply_time) ?> על ידי <strong><?= sanitize_input($last_username) ?></strong>
    <?php } ?>
  </div>
</div>