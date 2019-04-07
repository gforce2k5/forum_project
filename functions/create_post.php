<?php
  require_once "settings.php";
  $errors = [];
  if (!is_logged_in()) {
    $errors = add_error('user', 'לא ניתן לבצע את הפעולה אנא התחבר', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: ../");
  }

  if (isset($_POST['title']) && strlen($_POST['title']) > 0) {
    $title = $_POST['title'];
  } else {
    $errors = add_error('title', 'לא הוכנסה כותרת לפוסט', $errors);
  }

  if (isset($_POST['content']) && strlen($_POST['content']) > 0) {
    $content = $_POST['content'];
  } else {
    $errors = add_error('content', 'לא הכנסת תוכן לפוסט', $errors);
  }

  if (isset($_POST['parent']) && strlen($_POST['parent']) == 1) {
    $parent = $_POST['parent'];
    if ($parent != 'f' && $parent != 'p') {
      $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
    }
  } else {
    $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
  }

  if (isset($_POST['parent_id']) && is_numeric($_POST['parent_id'])) {
    $parent_id = intval($_POST['parent_id']);
  } else {
    $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
  }

  if (count($errors) > 0) {
    $_SESSION['errors'] = serialize($errors);
    header("location: ../");
  }

  $post = new Post($link, $title, $content, $current_user->get_id(), null, null, $parent == 'f' ? $parent_id : null, $parent == 'p' ? $parent_id : null);

  if (!$post->addToDb()) {
    $_SESSION['errors'] = serialize(add_error('sql', 'קרתה שגירה אנא נסה שוב', $errors));
    header("location: ../view_".$parent == 'f' ? 'forum' : 'topic'.".php?$parent=$parent_id");
  };

  header("location: ../view_topic.php?p=".($parent == 'f' ? $post->getId() : $parent_id));
?>