<?php
  require_once('settings.php');
  require_once('formvalidator.php');

  if ($_POST['Submit']) {
    $validator = new FormValidator();
    $validator->addValidation("confirm", "shouldelchk", "נא הסכם לתקנון");
    $validator->addValidation("name", "req", "נא הכנס שם משתמש");
    $validator->addValidation("name", "alnum", "שם המשתמש חייב להכיל אותיות ומספרים באנגלית בלבד");
    $validator->addValidation("name", "minlen=4", "שם משתמש חייב להכיל 4 תווים לפחות");
    $validator->addValidation("first_name", "req", "נא הכנס שם פרטי");
    $validator->addValidation("last_name", "req", "נא הכנס שם משפחה");
    $validator->addValidation("password", "req", "נא הכנס סיססמא");
    $validator->addValidation("password", "regexp=^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$",
      "הסיסמא חייבת להכיל 6 תווים לפחות וחייבת להעיל אות קטנה, אות גדולה ומספר");
    $validator->addValidation("password", "eqelmnt=confirm_pwd", "הסיסמאות שהכנסת לא זהות");
    $validator->addValidation("email", "req", "נא הכנס כתובת דוא\"ל");
    $validator->addValidation("email", "email", "נא הכנס כתובת דוא\"ל תקינה");

    if ($validator->ValidateForm()) {
      $sql = new SQL($link, "SELECT id FROM users WHERE username='{$_POST['username']}'");
      if ($sql->rows() > 0) {
        echo "שם המשתמש שבחרת תפוס";
      } else {
        $email_verification = md5(rand());
        $sql = new SQL($link, "INSERT INTO users(username, first_name, last_name, password, email, hash)".
          " VALUES ('{$_POST['username']}', '{$_POST['first_name']}', '{$_POST['last_name']}'".
          ", '{$_POST['password']}', '{$_POST['email']}', '$email_verification');");
      }
    } else {
      echo "<B>Validation Errors:</B>";

      $error_hash = $validator->GetErrors();
      foreach($error_hash as $inpname => $inp_err)
      {
        echo "<p>$inpname : $inp_err</p>\n";
      }
    }
  }

?>