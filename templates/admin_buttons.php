<div class="row">
  <div class="col-6">
    <?php
      $t_id = $post->getForumId() ? $post->getId() : $post->getPostId();
      $f_id = $post->getForumId() ? $post->getForumId() : Post::from_id($link, $post->getPostId())->getForumId();
      if (is_logged_in() && (is_manager($link, $current_user->get_id(), $f_id) || $current_user->get_status() == 2 || $current_user->get_id() === $author_id)) {
    ?>
        <a href="view_topic.php?p=<?= $t_id ?>&e=<?= $post->getId() ?>#<?= $post->getId() ?>" class="btn btn-warning">ערוך</a>
    <?php
      }
    ?>
  </div>
  <div class="col-6">
    <?php
      if (is_logged_in() && $current_user->get_status() == 2 || is_manager($link, $current_user->get_id(), $f_id)) {
    ?>
        <button class="btn btn-danger">מחק</button>
    <?php
      }
    ?>
  </div>
</div>