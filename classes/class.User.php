<?php
  class User {
    private $username = '';
    private $password = '';
    private $first_name = '';
    private $last_name = '';
    private $email = '';

    function __construct($username, $password, $first_name, $last_name, $email) {
      $this->username = $username;
      $this->password = $password;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
    }

    function add_to_db($link) {
      $user = mysqli_real_escape_string($link, $this->username);
      $email = mysqli_real_escape_string($link, $this->email);
      $fname = mysqli_real_escape_string($link, $this->first_name);
      $lname = mysqli_real_escape_string($link, $this->last_name);
      // $sql = new SQL($link, "SELECT * FROM users WHERE username='$user' OR email='$email';");
      // $sql = new SQL($link, "SELECT * FROM users WHERE username=$user OR email=$email;");
      $sql = new SQL($link, "SELECT id FROM users WHERE username = '$user' OR email = '$email'");
      if (!$sql->is_ok() || $sql->is_ok() && $sql->rows() >= 1) {
        return null;
      }

      $hash = md5(rand());
      $password = password_hash($this->password, PASSWORD_DEFAULT);

      $sql = new SQL($link, "INSERT INTO users(username, first_name, last_name, password, email, hash)".
        " VALUES ($user, $fname, $lname, $password, $email, $hash);");
    }
  }

?>