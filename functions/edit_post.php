<?php
  require_once "settings.php";
  $errors = [];
  if (!is_logged_in()) {
    $errors = add_error('login', 'אתה חייב להיות מחובר כדי לבצע פעולה זו', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: {$_SERVER['HTTP_REFERER']}");
  }

  array_merge($errors, validate_post($_POST, false));

  if (count($errors) > 0) {
    $_SESSION['errors'] = serialize($errors);
    header("location: {$_SERVER['HTTP_REFERER']}");
  }

  $title = $_POST['title'];
  $content = $_POST['content'];
  $p_id = $_POST['p_id'];
  $post = Post::from_id($link, $p_id);

  $f_id = $post->getForumId() ? $post->getForumId() : Post::from_id($link, $post->getPostId())->getForumId();

  if ($current_user->get_status() == 2 || $post->getAuthorId() == $current_user->get_id() || is_manager($link, $current_user->get_id(), $f_id)) {
    $post->setTitle($title);
    $post->setContent($content);
    $post->editDB();
    $_SESSION['success'] = 'הנושא נערך בהצלחה';
    $id = $post->getForumId() ? $post->getId() : $post->getPostId()."#{$post->getId()}";
    header("location: ../view_topic.php?p=$id");
  } else {
    $errors = add_error('user', 'אין לך הרשאה לביצוע בעולה זו', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: {$_SERVER['HTTP_REFERER']}");
  }

?>