<?php
  require_once "functions/settings.php";
  $errors = [];
  if (!is_logged_in()) {
    $errors = add_error('user', 'כדי להוסיף נושא עליך להתחבר', $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: ./");
  }

  if (isset($_GET['f']) && is_numeric($_GET['f'])) {
    $page_title = "הוספת נושא";
    require_once "header.php";
    $action = 'create';
    $parent = 'f';
    $parent_id = intval($_GET['f']);
    require_once "templates/post_form.php";
    require_once "footer.php";
  } else {
    $errors = add_error('error', 'קרתה שגיאה אנא נסה שוב', $errors);
    $_SESSION['errors'] = serialize('errors');
    header("location: ./");
  }
  
  ?>