<div style="border: 1px solid <?= $pinned ? 'red' : 'black' ?>">
  <h4><a href="view_topic.php?p=<?= $topic->getId() ?>"><?= htmlspecialchars($topic->getTitle()) ?></a></h4>
  <p>Author: <?= sanitize_input($author) ?></p>
  <p>Created At: <?= $topic->getCreationTime() ?></p>
  <p>Last Edit: <?= $topic->getEditTime() ?></p>
  <p>Reply count: <?= $post_count ?></p>
  <hr>
  <p><?= sanitize_input($topic->getContent()); ?></p>
  <hr>
  <?php if ($last_reply_time) { ?>
    <p>Last reply at: <?= $last_reply_time ?></p>
    <p>By: <?= $last_username ?></p>
  <?php } ?>
</div>