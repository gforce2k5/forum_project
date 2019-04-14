<?php
  require_once "settings.php";
  $errors = [];
  if (!is_logged_in()) {
    $errors = add_error('user', 'לא ניתן לבצע את הפעולה אנא התחבר', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: ../");
  }

  array_merge($errors, validate_post($_POST));

  if (count($errors) > 0) {
    $_SESSION['errors'] = serialize($errors);
    header("location: ../");
  }

  $title = $_POST['title'];
  $content = $_POST['content'];
  $parent = $_POST['parent'];
  $parent_id = intval($_POST['parent_id']);

  $post = new Post($link, $title, $content, $current_user->get_id(), null, null, $parent == 'f' ? $parent_id : null, $parent == 'p' ? $parent_id : null);

  if (!$post->addToDb()) {
    $_SESSION['errors'] = serialize(add_error('sql', mysqli_error($link), $errors));
    header("location: ../view_".$parent == 'f' ? 'forum' : 'topic'.".php?$parent=$parent_id");
  };

  if ($parent == 'p') {
    $parent_post = Post::from_id($link, $parent_id);
    $parent_post->updateActivity();
    if(!$parent_post->editDB()) {
      $_SESSION['errors'] = serialize(add_error('sql', mysqli_error($link), $errors));
    }
    header("location: ../view_".$parent == 'f' ? 'forum' : 'topic'.".php?$parent=$parent_id");
  }

  header("location: ../view_topic.php?p=".($parent == 'f' ? $post->getId() : $parent_id));
?>