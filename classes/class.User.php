<?php
  class User {
    private $username = '';
    private $password = '';
    private $first_name = '';
    private $last_name = '';
    private $email = '';
    private $id = null;
    private $avatar = null;
    private $register_timestamp = null;
    private $last_entry = null;
    private $is_admin = false;
    private $signature = '';
    private $is_verified = false;

    static function pull_from_db($link, $param, $is_id = false) {
      $param = mysqli_real_escape_string($link, $param);
      $sql = new SQL($link, "SELECT * FROM users WHERE ".
        ($is_id ? 'id' : 'username')." = '$param'");
      if ($sql->is_ok() && $sql->rows() == 1) {
        $results = $sql->result();
        $id = $results['id'];
        $username = $results['username'];
        $password = $results['password'];
        $first_name = $results['first_name'];
        $last_name = $results['last_name'];
        $email = $results['email'];
        $avatar = $results['avatar'];
        $register_timestamp = $results['register_date'];
        $last_entry = $results['last_entry'];
        $is_admin = $results['is_admin'];
        $signature = $results['signature'];
        $is_verified = $results['is_verified'];
        return new User($username, $password, $first_name, $last_name, $email, $id, $avatar, $register_timestamp,
          $last_entry, $is_admin, $signature, $is_verified);
      }
    }

    function __construct($username, $password, $first_name, $last_name, $email, $id = null,
      $avatar = null, $register_timestamp = null, $last_entry = null, $is_admin = false, $signature = '', $is_verified = false) {
      $this->username = $username;
      $this->password = $password;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      if ($id) $this->id = $id;
      if ($avatar) $this->avatar = $avatar;
      if ($register_timestamp) $this->register_timestamp = $register_timestamp;
      if ($last_entry) $this->last_entry = $last_entry;
      if ($is_admin) $this->is_admin = $is_admin;
      if ($signature) $this->signature = $signature;
      if ($is_verified) $this->is_verified = false;
    }

    function get_username() {
      return $this->username;
    }

    function get_first_name() {
      return $this->first_name;
    }

    function get_last_name() {
      return $this->last_name;
    }

    function get_email() {
      return $this->email;
    }

    function get_avatar() {
      return $this->avatar;
    }

    function get_register_timestamp() {
      return $this->register_timestamp;
    }

    function get_last_entry() {
      return $this->last_entry;
    }

    function is_adnin() {
      return $this->is_admin;
    }

    function get_signature() {
      return $this->signature;
    }

    function is_verified() {
      return $this->is_verified();
    }

    function get_session_id() {
      if (password_is_hash($this->password)) {
        return password_hash($this->id.$this->password, PASSWORD_DEFAULT);
      } else {
        return password_hash($this->id.password_hash($this->password, PASSWORD_DEFAULT), PASSWORD_DEFAULT);
      }
    }

    function add_to_db($link) {
      $user = mysqli_real_escape_string($link, $this->username);
      $email = mysqli_real_escape_string($link, $this->email);
      $fname = mysqli_real_escape_string($link, $this->first_name);
      $lname = mysqli_real_escape_string($link, $this->last_name);
      $sql = new SQL($link, "SELECT id FROM users WHERE username = '$user' OR email = '$email'");
      if (!$sql->is_ok() || $sql->is_ok() && $sql->rows() >= 1) {
        return null;
      }

      $password = password_hash($this->password, PASSWORD_DEFAULT);

      $hash = md5(rand());

      $sql = new SQL($link, "INSERT INTO users(username, first_name, last_name, password, email, hash)".
        " VALUES ('$user', '$fname', '$lname', '$password', '$email', '$hash');");

      $sql = new SQL($link, "SELECT id FROM users WHERE username = {$this->username}");
      $this->id = $sql->result()['id'];
    }

    function get_hashed_password() {
      return $this->password;
    }

    function get_id() {
      return $this->id;
    }

    function login_session($link) {
      $_SESSION['is_logged_in'] = true;
      $_SESSION['user'] = serialize($this);
      $_SESSION['sessionid'] = $this->get_session_id();
      $this->update_last_entry($link);
    }

    function update_last_entry($link) {
      if ($this->id) {
        $sql = new SQL($link, "UPDATE users SET last_entry = {time()} WHERE id = '$this->id'");
      }
    }
  }

?>