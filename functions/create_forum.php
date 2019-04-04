<?php
  require_once("settings.php");
  if (!is_logged_in()) header("location:../");
  $user = unserialize($_SESSION['user']);
  if (!$user->get_status() == 2) {
    $errors = add_error("create_forum", "אין לך הרשאה לביצוע פעולה זו", $errors);
    $_SESSION['errors'] = serialize($errors);
    header("location: ../");
  }

  $errors = [];
  $cat_id = $manager_id = null;

  if (isset($_POST['Submit'])) {
    if (isset($_POST['name']) && strlen($_POST['name']) > 0) {
      $name = $_POST['name'];
    } else {
      $errors = add_error('name', 'לא הוכנס שם פורום', $errors);
    }

    if (isset($_POST['description']) && strlen($_POST['description']) > 0) {
      $description = $_POST['description'];
    } else {
      $errors = add_errors('description', 'לא הוכנס תיאור פורום', $errors);
    }

    if (isset($_POST['cat_order'])) $cat_order = $_POST['cat_order'];

    if (isset($_POST['cat_id']) && is_numeric($_POST['cat_id'])) {
      $cat_id = intval($_POST['cat_id']);
    } else {
      if ($cat_id == '') $errors = add_error('cat_id', 'לא נבחרה קטגוריה', $errors);
      else $errors = add_error('cat_id', 'קטגוריה לא חוקית', $errors);
    }

    if (isset($_POST['other'])) $cat_name = $_POST['other'];

    if (isset($_POST['manager']) && is_numeric($_POST['manager'])) {
      $manager_id = intval($_POST['manager']);
    } else {
      $errors = add_error('manager', 'לא נבחר מנהל פורום', $errors);
    }

    if (count($errors) > 0) {
      $_SESSION['errors'] = serialize($errors);
      header("location: ../create_forum.php");
    }

    if ($cat_id == -1) {
      if (strlen($cat_name) == 0) {
        $errors = add_error('אחר', 'שם הקטגוריה שבחרת להוסיף ריק', $errors);
        $_SESSION['errors'] = serialize($errors);
        header("location: ../create_forum.php");
      }
      $category = new Category($cat_name);
      if (!$category->add_to_db($link)) {
        $errors = add_error('sql', 'הקטגוריה שהוספת כבר קיימת', $errors);
        $_SESSION['errors'] = serialize($errors);
        header("location: ../create_forum.php");
      }
      $cat_id = $category->get_id();
    }

    $cat_id = mysqli_real_escape_string($link, $cat_id);

    $sql = new SQL($link, "SELECT id FROM categories WHERE id = '$cat_id'");

    if (!$sql->is_ok() || ($sql->is_ok() && $sql->rows() == 0)) {
      $errors = add_error('sql', 'הקטגוריה שנבחרה לא קיימת', $errors);
      $_SESSION['errors'] = serialize($errors);
      header("location: ../create_forum.php");
    }

    $sql = new SQL($link, "SELECT id FROM users WHERE id = '$manager_id' AND status >= 1");

    if (!$sql->is_ok() || ($sql->is_ok() && $sql->rows() == 0)) {
      $errors = add_error('sql', 'המשתמש שנבחר לא קיים או לא פעיל', $errors);
      $_SESSION['errors'] = serialize($errors);
      header("location: ../create_forum.php");
    }

    $forum = new Forum($name, $description, $cat_id);
    if (!$forum->add_to_db($link)) {
      $errors = add_error('sql', 'פורום בעל שם זהה כבר קיים', $errors);
      $_SESSION['erros'] = serialize($errors);
      header("location: ../create_forum.php");
    }

    $manager_id = mysqli_real_escape_string($link, $manager_id);
    $forum_id = $forum->get_id();

    $sql = new SQL($link, "INSERT INTO forum_managers (user_id, forum_id) VALUES($manager_id, $forum_id)");

    if (!$sql->is_ok()) {
      $errors = add_error('sql', 'קרתה שגיאה בהוספת מנהל לפורום', $errors);
      $_SESSION['erros'] = serialize($errors);
      header("location: ../create_forum.php");
    }

    $_SESSION['success'] = 'הפורום נוסף בהצלחה';
  }
  header("location: ../");
?>