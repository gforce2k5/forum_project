<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">עמוד הבית</a></li>
    <li class="breadcrumb-item"><a href="./view_category.php?c=<?= $cat_id ?>"><?= $cat_name ?></a></li>
    <li class="breadcrumb-item"><a href="./view_forum.php?f=<?= $forum->get_id() ?>"><?= sanitize_input($forum->get_name()) ?></li>
  </ol>
</nav>

<h1><?= sanitize_input($topic->getTitle()) ?></h1>
<?php
  $is_topic = true;
  $post = $topic;
  $sql = new SQL($link, "SELECT username FROM users WHERE id = {$topic->getAuthorId()}");
  $author = $sql->result()['username'];
  include "templates/post.php";
  $post->showPosts(true);
  $post->showPosts();
  $action = 'create';
  $parent = 'p';
  $parent_id = $post->getId();
  include "post_form.php";
?>
