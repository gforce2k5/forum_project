<?php
  require_once "../functions/settings.php";
  if (is_logged_in() && $current_user->get_status() == 2) {
    if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 0) {
      $name = trim($_POST['name']);
    } else {
      echo "שם הפורום לא יכול להיות ריק";
    }

    if (isset($_POST['description']) && strlen(trim($_POST['description'])) > 0) {
      $description = trim($_POST['description']);
    } else {
      echo "תיאור הפורום לא יכול להישאר ריק";
    }

    if (isset($_POST['managers'])) {
      $data = json_decode($_POST['managers']);
      if (count($data) == 0) {
        echo "לא נבחרו מנהלים";
      } else {
        $managers = $data;
      }
    }

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
      $id = intval($_POST['id']);
    } else {
      echo "מזהה הפורום חייב להיות מספר";
    }

    if (isset($_POST['active']) && is_numeric($_POST['active'])) {
      $active = intval($_POST['active']);
    } else {
      echo "שגיאה בהעברת הנתונים";
    }

    if (isset($name) && isset($description) && isset($managers) && isset($id) && isset($active)) {

      $name = mysqli_real_escape_string($link, $name);
      $id = mysqli_real_escape_string($link, $id);

      $sql = new SQL($link, "SELECT id FROM forums WHERE name = '$name' AND id <> $id");
      if ($sql->is_ok()) {
        if ($sql->rows() != 0) {
          echo "פורום עם השם הנבחר קיים";
        } else {
          $forum = Forum::from_id($link, $id);
          $forum->set_name($name);
          $forum->set_description($description);
          $forum->set_active($active);
          print_array($forum);
          $users_ok = true;

          foreach ($managers as $key => $m_id) {
            $m_id = mysqli_real_escape_string($link, intval($m_id));
            $managers[$key] = $m_id;
            $usersql = new SQL($link, "SELECT id FROM users WHERE id = $m_id AND status >= 1");
            if (!$usersql->is_ok() || $usersql->rows() == 0) {
              $users_ok = false;
              break;
            }
          }

          if ($users_ok) {
            $forum->edit_db($link);
            $sql = new SQL($link, "DELETE FROM forum_managers WHERE forum_id = $id");
            foreach ($managers as $key => $m_id) {
              $usql = new SQL($link, "INSERT INTO forum_managers (forum_id, user_id) VALUES ($id, $m_id)");
            }
          } else {
            echo "חלה שגיאה במשתמשים";
          }
        }
      } else {
        echo "שגיאת SQL";
      }
    } else {
      echo "חלה שגיאה";
    }
  } else {
    echo "משצמש לא מורשה";
  }
?>