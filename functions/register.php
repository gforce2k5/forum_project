<?php
  require_once('settings.php');

  $username = $password = $email = $confirmpwd = $divur = $fname = $lname = "";

  $errors = [];

  if (isset($_POST['Submit']) && $_POST['Submit']) {
    if (isset($_POST['username'])) {
      $username = test_input($_POST['username']);
      if (!preg_match('/^[A-Za-z0-9]{4,}$/', $username)) {
        $errors = add_error('username', 'שם המשתמש יכול להכיל אותיות גדולות וקטנות באנגלית ומספרים בלבד', $errors);
      }
    } else {
      $errors = add_error('username', 'נא הכנס שם משתמש', $errors);
    }

    if (isset($_POST['password']) && isset($_POST['confirmpwd'])) {
      $password = test_input($_POST['password']);
      $confirmpwd = test_input($_POST['confirmpwd']);
      if (!($password === $confirmpwd)) {
        $errors = add_error('password', 'הסיסמאות שהוכנסו לא זהות', $errors);
      } else {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password)) {
          $errors = add_error('password', 'הסיסמא חייבת להכיל לפחות אות גדולה, אות קטנה ומספר', $errors);
        }
      }
    } else {
      $errors = add_error('password', 'אחת משדות הסיסמא ריקות', $errors);
    }

    if (isset($_POST['email'])) {
      $email = test_input($_POST['email']);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = add_error('email', 'האימייל שהוכנס אינו תקין', $errors);
      }
    } else {
      $errors = add_error('email', 'לא הוכנסה כתובת אימייל', $errors);
    }

    if (isset($_POST['first_name'])) {
      $fname = test_input($_POST['first_name']);
    } else {
      $errors = add_error('fname', 'לא הוכנס שם פרטי', $errors);
    }

    if (isset($_POST['last_name'])) {
      $lname = test_input($_POST['last_name']);
    } else {
      $errors = add_error('lname', 'לא הוכנס שם משפחה', $errors);
    }
    
    if (!isset($_POST['divur'])) {
      $errors = add_error("divur", "קרא את התקנון ואשר אותו", $errors);
    }

    if (count($errors) === 0) {
      $user = new User($username, $password, $fname, $lname, $email);
      $user->add_to_db($link);
    } else {
      echo '<pre>';
      print_r($errors);
      print_r($_POST);
      echo '</pre>';
    }
  }
  
  ?>