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

  if ($parent == 'f' && ($current_user->get_status() == 2 || $current_user->is_manager($link, $parent_id))) {
    if (isset($_POST['pin']) && $_POST['pin']) {
      $post->pinPost();
    }
  }

  if ($parent == 'p') {
    $parent_post = Post::from_id($link, $parent_id);
    $forum = Forum::from_id($link, $parent_post->getForumId());
    if (($parent_post->isLocked() || $forum->is_locked()) && $current_user->get_status() != 2 && !$current_user->is_manager($link, $parent_post->getForumId)) {
      $_SESSION['errors'] = serialize(add_error('auth', 'לא ניתן להוסיף תגובה לנושא נעול', $errors));
      header("location: {$_SERVER['HTTP_REFERER']}");
    } else {
      $parent_post->updateActivity();
      if(!$parent_post->editDB()) {
        $_SESSION['errors'] = serialize(add_error('sql', mysqli_error($link), $errors));
      }
    header("location: ../view_".$parent == 'f' ? 'forum' : 'topic'.".php?$parent=$parent_id");
    }
  } else {
    $forum = Forum::from_id($link, $parent_id);
    if (!$forum->is_active() && !$current_user->get_status() != 2 && !$current_user->is_manager($link, $parent_id)) {
      $_SESSION['errors'] = serialize(add_error('auth', 'לא ניתן להוסיף נושא בפורום לא פעיל', $errors));
      header("location: {$_SERVER['HTTP_REFERER']}");
    }
  }

  if (!$post->addToDb()) {
    $_SESSION['errors'] = serialize(add_error('sql', mysqli_error($link), $errors));
    header("location: ../view_".$parent == 'f' ? 'forum' : 'topic'.".php?$parent=$parent_id");
  };


  header("location: ../view_topic.php?p=".($parent == 'f' ? $post->getId() : $parent_id));
?>