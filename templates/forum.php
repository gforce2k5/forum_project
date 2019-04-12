<div class="col-6 text-right <?= $classes[$counter] ?>">
  <strong><a class="<?= explode(' ', $classes[$counter])[1] ?>" href="view_forum.php?f=<?= $forum['id'] ?>">
    <?= sanitize_input($forum['name']) ?>
  </a></strong>
  <p>
    <?= sanitize_input($forum['description']) ?>
  </p>
</div>
<div class="col-2 text-center <?= $classes[$counter] ?>"><?= $topic_count ?></div>
<div class="col-2 text-center <?= $classes[$counter] ?>"><?= $post_count ?></div>
<div class="col-2 text-left <?= $classes[$counter] ?>">
  <?php
    if ($last_post_time) {
  ?>
      נכתבה על ידי <?= $username ?> בתאריך <?= format_time($last_post_time) ?>
  <?php
    }
  ?>
</div>