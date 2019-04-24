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

  $f_id = $post->getForumId();

  if ($current_user->get_status() == 2 || $post->getAuthorId() == $current_user->get_id() || $current_user->is_manager($link, $f_id)) {
    if ($post->getAuthorId() != $current_user->get_id) {
      if (isset($_POST['pin']) && $_POST['pin']) {
        $post->pinPost();
      } else {
        $post->unpinPost();
      }
      if (isset($_POST['lock']) && $_POST['lock']) {
        $post->lockPost();
      } else {
        $post->unlockPost();
      }
    }
    $post->setTitle($title);
    $post->setContent($content);
    $post->editDB();
    $_SESSION['success'] = 'הנושא נערך בהצלחה';
    $id = $post->getPostId() ? $post->getPostId()."#{$post->getId()}" : $post->getId();
    header("location: ../view_topic.php?p=$id");
  } else {
    $errors = add_error('user', 'אין לך הרשאה לביצוע בעולה זו', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: {$_SERVER['HTTP_REFERER']}");
  }

?>