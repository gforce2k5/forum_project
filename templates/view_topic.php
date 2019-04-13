<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><?= sanitize_input($cat_name) ?></a></li>
    <li class="breadcrumb-item"><a href="./view_forum.php?f=<?= $forum->get_id() ?>"><?= sanitize_input($forum->get_name()) ?></a></li>
  </ol>
</nav>

<h3 class="text-right"><?= sanitize_input($topic->getTitle()) ?></h3>
<?php if (!$topic->isLocked() && is_logged_in()) { ?>
  <div class="text-right mb-5">
    <a data-toggle="modal" data-target="#create-post-modal" class="btn btn-primary" href="#">תגובה חדשה</a>
  </div>
<?php
    $action = 'create';
    $parent = 'p';
    $parent_id = $topic->getId();
    include "templates/post_form.php";
  }
?>
<?php
  $is_topic = true;
  $post = $topic;
  $sql = new SQL($link, "SELECT username, register_date FROM users WHERE id = {$topic->getAuthorId()}");
  $result = $sql->result();
  $author = $result['username'];
  $register_date = $result['register_date'];
  $counter = 0;
  include "templates/post.php";
  $post->showPosts(true);
  $post->showPosts();
  $action = 'create';
  $parent = 'p';
  $parent_id = $post->getId();
  include "post_form.php";
?>
