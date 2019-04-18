<div class="col-6 text-right <?= $classes[$counter] ?>">
  <div class="row">
    <div class="col-2 icon"><i class="fas fa-info-circle"></i></div>
    <div class="col-10">
      <strong><a class="<?= explode(' ', $classes[$counter])[1] ?>" href="view_forum.php?f=<?= $forum['id'] ?>">
        <?= sanitize_input($forum['name']) ?>
      </a></strong>
      <p>
        <?= sanitize_input($forum['description']) ?>
      </p>
      <p>
        מנוהל ע"י: 
        <?php
          $managers = Forum::getManagers($link, $forum['id']);
          $text = '';
          if ($managers) {
            while ($manager = $managers->result()) {
              $text .= $manager['username'].", ";
            }
            if ($text != '') $text = substr($text, 0, strlen($text) - 2);
          }

          echo $text;
        ?>
      </p>
    </div>
  </div>
</div>
<div class="col-2 text-center <?= $classes[$counter] ?>"><?= $topic_count ?></div>
<div class="col-2 text-center <?= $classes[$counter] ?>"><?= $post_count ?></div>
<div class="col-2 text-left <?= $classes[$counter] ?>">
  <?php
    if (isset($last_post)) {
  ?>
      <strong><a class=<?= explode(' ', $classes[$counter])[1] ?> href="view_topic.php?p=<?= $last_post->getId() ?>"><i class="fas fa-sticky-note"></i> <?= $last_post->getTitle() ?></a></strong><br />
      נכתב על ידי <strong><?= sanitize_input($username) ?></strong> בתאריך <?= format_time($last_post->getCreationTime()) ?>
  <?php
    }
  ?>
</div>