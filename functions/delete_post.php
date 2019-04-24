<?php
  require_once "settings.php";
  $errors = [];
  if (isset($_POST['p']) && is_numeric($_POST['p'])) {
    $p_id = intval($_POST['p']);
    $post = Post::from_id($link, $p_id);
    if ($post) {
      $f_id = $post->getForumId();
      if (is_logged_in() && ($current_user->get_status() == 2 || $current_user->is_manager($link, $f_id))) {
        if ($post->delete()) {;
          $_SESSION['success'] = 'הפוסט נמחק בהצלחה';
          if ($post->getPostId()) {
            $location = "../view_topic.php?p={$post->getPostId()}";
          } else {
            $location = "../view_forum.php?f={$post->getForumId()}";
          }
          header("location: $location");
        } else {
          $errors = add_error('error', 'חלה שגיאה1', $errors);
        }
      } else {
        $erorrs = add_error('user', 'אין לך הרשאה לביצוע פעולה זו', $erorrs);
      }
    } else {
      $errors = add_error('post', 'הפוסט שניסית למחוק לא קיים', $errors);
    }
  } else {
    $errors = add_error('error', 'חלה שגיאה2', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: {$_SERVER['HTTP_REFERER']}");
  }
?>