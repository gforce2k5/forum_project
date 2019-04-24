<?php
  require_once("settings.php");
  if (!is_logged_in()) header("location:../");
  if (!$current_user->get_status() == 2) {
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
      $errors = add_error('description', 'לא הוכנס תיאור פורום', $errors);
    }

    if (isset($_POST['cat_order'])) $cat_order = $_POST['cat_order'];

    if (isset($_POST['cat_id']) && is_numeric($_POST['cat_id'])) {
      $cat_id = intval($_POST['cat_id']);
    } else {
      if ($cat_id == '') $errors = add_error('cat_id', 'לא נבחרה קטגוריה', $errors);
      else $errors = add_error('cat_id', 'קטגוריה לא חוקית', $errors);
    }

    if (isset($_POST['other'])) $cat_name = $_POST['other'];

    $managers = [];
    $manager_ids = [];

    if (isset($_POST['managers']) && is_array($_POST['managers']) && count($_POST['managers']) > 0) {
      $managers = $_POST['managers'];
      foreach($managers as $key => $value) {
        if (is_numeric($value)) {
          array_push($manager_ids, intval($value));
        } else {
          $errors = add_error('managers', 'נבחר מנהל לא חוקי', $errors);
          break;
        }
      }
    } else {
      $errors = add_error('managers', 'לא נבחר מנהל פורום', $errors);
    }

    if (count($errors) > 0) {
      $_SESSION['errors'] = serialize($errors);
      header("location: ../");
    }

    if ($cat_id == -1) {
      if (strlen($cat_name) == 0) {
        $errors = add_error('אחר', 'שם הקטגוריה שבחרת להוסיף ריק', $errors);
        $_SESSION['errors'] = serialize($errors);
        header("location: ../");
      }
      $category = new Category($cat_name);
      if (!$category->add_to_db($link)) {
        $errors = add_error('sql', 'הקטגוריה שהוספת כבר קיימת', $errors);
        $_SESSION['errors'] = serialize($errors);
        $sql = new SQL($link, "SELECT * FROM categories WHERE name = $cat_name");
        if ($sql->is_ok()) {
          $category = Category::category_from_sql($sql->result());
        } else {
          header("location: ../");
        }
      }
      $cat_id = $category->get_id();
    }

    $cat_id = mysqli_real_escape_string($link, $cat_id);

    $sql = new SQL($link, "SELECT id FROM categories WHERE id = '$cat_id'");

    if (!$sql->is_ok() || ($sql->is_ok() && $sql->rows() == 0)) {
      $errors = add_error('sql', 'הקטגוריה שנבחרה לא קיימת', $errors);
      $_SESSION['errors'] = serialize($errors);
      header("location: ../");
    }

    foreach($manager_ids as $key => $manager_id) {
      $manager_id = mysqli_real_escape_string($link, intval($manager_id));
      $sql = new SQL($link, "SELECT id FROM users WHERE id = '$manager_id' AND status >= 1");
  
      if (!$sql->is_ok() || ($sql->is_ok() && $sql->rows() == 0)) {
        $errors = add_error('sql', 'המשתמש שנבחר לא קיים או לא פעיל', $errors);
        $_SESSION['errors'] = serialize($errors);
        header("location: ../");
      }
      $manager_ids[$key] = $manager_id;
    }

    $forum = new Forum($name, $description, $cat_id);
    if (!$forum->add_to_db($link)) {
      $errors = add_error('sql', 'פורום בעל שם זהה כבר קיים', $errors);
      $_SESSION['erros'] = serialize($errors);
      header("location: ../");
    }
    
    $forum_id = $forum->get_id();

    foreach($manager_ids as $key => $manager_id) {
  
      $sql = new SQL($link, "INSERT INTO forum_managers (user_id, forum_id) VALUES($manager_id, $forum_id)");
  
      if (!$sql->is_ok()) {
        $errors = add_error('sql', 'קרתה שגיאה בהוספת מנהל לפורום', $errors);
        $_SESSION['erros'] = serialize($errors);
        header("location: ../");
      }
    }

    $_SESSION['success'] = 'הפורום נוסף בהצלחה';
  }
  header("location: ../");
?>