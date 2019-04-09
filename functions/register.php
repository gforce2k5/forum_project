<?php
  require_once('settings.php');

  $username = $password = $email = $confirmpwd = $divur = $fname = $lname = "";

  $errors = [];

  if (isset($_POST['Submit']) && $_POST['Submit']) {
    if (isset($_POST['username']) && strlen($_POST['username']) > 0) {
      $username = $_POST['username'];
      if (!preg_match('/^[A-Za-z0-9]{4,}$/', $username)) {
        $errors = add_error('username', 'שם המשתמש יכול להכיל אותיות גדולות וקטנות באנגלית ומספרים בלבד האואך המינימלי הוא 4 תווים', $errors);
      }
    } else {
      $errors = add_error('username', 'נא הכנס שם משתמש', $errors);
    }

    if (isset($_POST['password']) && isset($_POST['confirmpwd']) && strlen($_POST['password']) > 0 && strlen($_POST['confirmpwd']) > 0) {
      $password = $_POST['password'];
      $confirmpwd = $_POST['confirmpwd'];
      if (!($password === $confirmpwd)) {
        $errors = add_error('password', 'הסיסמאות שהוכנסו לא זהות', $errors);
      } else {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
          $errors = add_error('password', 'הסיסמא חייבת להכיל לפחות אות גדולה, אות קטנה ומספר. הסיסמה חייבת להכיל לפחות 6 תווים', $errors);
        }
      }
    } else {
      $errors = add_error('password', 'אחת משדות הסיסמה ריקות', $errors);
    }

    if (isset($_POST['email']) && strlen($_POST['email']) > 0) {
      $email = $_POST['email'];
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = add_error('email', 'האימייל שהוכנס אינו תקין', $errors);
      }
    } else {
      $errors = add_error('email', 'לא הוכנסה כתובת אימייל', $errors);
    }

    if (isset($_POST['first_name']) && strlen(trim($_POST['first_name'])) > 0) {
      $fname = trim($_POST['first_name']);
    } else {
      $errors = add_error('fname', 'לא הוכנס שם פרטי', $errors);
    }

    if (isset($_POST['last_name']) && strlen(trim($_POST['last_name'])) > 0) {
      $lname = trim($_POST['last_name']);
    } else {
      $errors = add_error('lname', 'לא הוכנס שם משפחה', $errors);
    }
    
    if (!isset($_POST['divur'])) {
      $errors = add_error("divur", "קרא את התקנון ואשר אותו", $errors);
    }

    if (count($errors) === 0) {
      $user = new User($username, $password, $fname, $lname, $email);
      if (!$user->add_to_db($link)) {
        $errors = add_error('username', 'שם המשתמש שבחרת תפוס', $errors);
        $_SESSION['errors'] = serialize($errors);
      } else {
        $_SESSION['success'] = 'הרישום התבצע כהלכה';
      };
      header("location: ../");
    } else {
      $_SESSION['errors'] = serialize($errors);
      header("location: ../");
    }
  }
  // header("location: ../");
  
  ?>