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
  }

?>