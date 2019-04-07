<div style="border: 1px solid <?= $is_topic ? 'red' : 'black' ?>">
  <h4 id="<?= $post->getId() ?>">
    <a href="#<?= $post->getId() ?>"><?= sanitize_input($post->getTitle()) ?></a>
    <?php
      if ($post->isPinned()) {
        echo " --- PIN";
      }
    ?>
  </h4>
  <p><?= sanitize_input($post->getContent()); ?></p>
  <hr>
  <p>Author: <?= sanitize_input($author) ?></p>
  <p>Created At: <?= $post->getCreationTime() ?></p>
  <p>Last Edit: <?= $post->getEditTime() ?></p>
</div>