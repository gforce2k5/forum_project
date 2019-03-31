<?php
  class User {
    private $username = '';
    private $password = '';
    private $first_name = '';
    private $last_name = '';
    private $email = '';
    private $id = null;
    private $avatar = null;
    private $register_date = null;
    private $last_entry = null;
    private $is_admin = false;
    private $signature = '';
    private $status = false;

    static function pull_from_db($link, $param, $is_id = false) {
      $param = mysqli_real_escape_string($link, $param);
      $sql = new SQL($link, "SELECT * FROM users WHERE ".
        ($is_id ? 'id' : 'username')." = '$param'");
      if ($sql->is_ok() && $sql->rows() == 1) {
        $result = $sql->result();
        $id = $result['id'];
        $username = $result['username'];
        $password = $result['password'];
        $first_name = $result['first_name'];
        $last_name = $result['last_name'];
        $email = $result['email'];
        $avatar = $result['avatar'];
        $register_date = $result['register_date'];
        $last_entry = $result['last_entry'];
        $is_admin = $result['is_admin'];
        $signature = $result['signature'];
        $status = $result['status'];
        return new User($username, $password, $first_name, $last_name, $email, $id, $avatar, $register_date,
          $last_entry, $is_admin, $signature, $status);
      }
    }

    function __construct($username, $password, $first_name, $last_name, $email, $id = null,
      $avatar = null, $register_date = null, $last_entry = null, $is_admin = false, $signature = '', $status = false) {
      $this->username = $username;
      $this->password = $password;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      if ($id) $this->id = $id;
      if ($avatar) $this->avatar = $avatar;
      if ($register_date) $this->register_date = $register_date;
      if ($last_entry) $this->last_entry = $last_entry;
      if ($is_admin) $this->is_admin = $is_admin;
      if ($signature) $this->signature = $signature;
      if ($status) $this->status = false;
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

    function get_register_date() {
      return $this->register_date;
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

    function status() {
      return $this->status;
    }

    function get_session_id($encript = true) {
      $res = '';
      if (password_is_hash($this->password)) {
        $res = $this->id.$this->password;
      } else {
        $res = $this->id.password_hash($this->password, PASSWORD_DEFAULT);
      }
      if ($encript) {
        return password_hash($res, PASSWORD_DEFAULT);
      }

      return $res;
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

      $password = password_hash($this->password, PASSWORD_BCRYPT);

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
        new SQL($link, "UPDATE users SET last_entry = '".date('Y-m-d H:i:s', time())."' WHERE id = '$this->id'");
      }
    }
  }

?>