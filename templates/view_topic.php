<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i> עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><i class="fas fa-circle-notch"></i> <?= sanitize_input($cat_name) ?></a></li>
    <li class="breadcrumb-item"><a href="./view_forum.php?f=<?= $forum->get_id() ?>"><i class="fas fa-info-circle"></i> <?= sanitize_input($forum->get_name()) ?></a></li>
  </ol>
</nav>

<h3 class="text-right"><?= sanitize_input($topic->getTitle()) ?></h3>
<?php if (is_logged_in()) {
   if (!$topic->isLocked() && $forum->is_active() || $current_user->get_status() == 2 || $current_user->is_manager($link, $forum->get_id())) {?>
    <div class="text-right mb-5">
      <a data-toggle="modal" data-target="#create-post-modal" class="btn btn-primary text-light"><i class="fas fa-reply"></i> תגובה חדשה</a>
    </div>
<?php
      $action = 'create';
      $parent = 'p';
      $parent_id = $topic->getId();
      include "templates/post_form.php";
    }

    if ($current_user->get_status() == 2 || $current_user->is_manager($link, $forum->get_id())) {
      include "templates/delete_post_form.php";
    }
  }
  $is_topic = true;
  $edit = false;
  if ($topic->getId() == $e_id) {
    $edit = true;
  }
  $post = $topic;
  $sql = new SQL($link, "SELECT username, register_date FROM users WHERE id = {$topic->getAuthorId()}");
  $result = $sql->result();
  $author = $result['username'];
  $register_date = $result['register_date'];
  $counter = 0;
  $bb_parser = new bbParser();
  include "templates/post.php";
  $post->showPosts(true, $e_id);
  $post->showPosts(false, $e_id);
?>
