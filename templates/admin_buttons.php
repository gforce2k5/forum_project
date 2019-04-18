<div class="row">
  <div class="col-6">
    <?php
      $t_id = $post->getPostId() ? $post->getPostId() : $post->getId();
      $f_id = $post->getForumId();
      if (is_logged_in() && ($current_user->is_manager($link, $f_id) || $current_user->get_status() == 2 || ($current_user->get_id() === $author_id && !$topic->isLocked() && $forum->is_active()))) {
    ?>
        <a href="view_topic.php?p=<?= $t_id ?>&e=<?= $post->getId() ?>#<?= $post->getId() ?>" class="btn btn-warning"><i class="fas fa-edit"></i> ערוך</a>
    <?php
      }
    ?>
  </div>
  <div class="col-6">
    <?php
      if (is_logged_in() && ($current_user->get_status() == 2 || $current_user->is_manager($link, $f_id))) {
    ?>
        <button data-toggle="modal" data-id="<?= $post->getId() ?>" data-target="#delete-post-modal" class="btn btn-danger delete"><i class="far fa-trash-alt"></i> מחק</button>
    <?php
      }
    ?>
  </div>
</div>