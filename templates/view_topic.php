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
