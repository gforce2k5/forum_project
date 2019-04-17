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
        $signature = $result['signature'];
        $status = $result['status'];
        return new User($username, $password, $first_name, $last_name, $email, $id, $avatar, $register_date,
          $last_entry, $signature, $status);
      }
    }

    static function get_active_users($link) {
      $sql = new SQL($link, "SELECT id, username FROM users WHERE status >= 1");
      
      if (!$sql->is_ok()) return false;

      $html = '';

      while ($user = $sql->result()) {
        $html .= '<option value="'.$user['id'].'">'.sanitize_input($user['username']).'</option>';
      }

      return $html;
    }

    function __construct($username, $password, $first_name, $last_name, $email, $id = null,
      $avatar = null, $register_date = null, $last_entry = null, $signature = '', $status = 0) {
      $this->username = $username;
      $this->password = $password;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      if ($id) $this->id = $id;
      if ($avatar) $this->avatar = $avatar;
      if ($register_date) $this->register_date = $register_date;
      if ($last_entry) $this->last_entry = $last_entry;
      if ($signature) $this->signature = $signature;
      if ($status) $this->status = $status;
    }

    function set_username($value) {
      $this->username = $value;
    }

    function get_username() {
      return $this->username;
    }

    function set_password($value) {
      if (!password_is_hash($value)) {
        $value = password_hash($value, PASSWORD_BCRYPT);
      }
      $this->password = $value;
    }

    function set_first_name($value) {
      $this->first_name = $value;
    }

    function get_first_name() {
      return $this->first_name;
    }

    function set_last_name($value) {
      $this->last_name = $value;
    }

    function get_last_name() {
      return $this->last_name;
    }

    function email($value) {
      $this->email = $value;
    }

    function get_email() {
      return $this->email;
    }

    function set_avatar($value) {
      $this->avatar = $value;
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

    function get_signature() {
      return $this->signature;
    }

    function set_signature($value) {
      $this->signature = $value;
    }

    function get_status() {
      return $this->status;
    }

    function unlock_user() {
      $this->status = 1;
    }

    function make_admin() {
      $this->status = 2;
    }

    function lock_user() {
      $this->status = 0;
    }

    function get_session_id($encript = true) {
      $res = '';
      if (password_is_hash($this->password)) {
        $res = $this->id.$this->password;
      } else {
        $res = $this->id.password_hash($this->password, PASSWORD_BCRYPT);
      }
      if ($encript) {
        return password_hash($res, PASSWORD_BCRYPT);
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
        return false;
      }

      $password = password_hash($this->password, PASSWORD_BCRYPT);

      $hash = sha1(md5(random_int(PHP_INT_MIN, PHP_INT_MAX)));

      $sql = new SQL($link, "INSERT INTO users(username, first_name, last_name, password, email, hash)".
        " VALUES ('$user', '$fname', '$lname', '$password', '$email', '$hash');");

      if (!$sql->is_ok()) {
        return false;
      }

      $this->id = $sql->get_id();
      return true;
    }

    function edit_user_db($link) {
      $user = mysqli_real_escape_string($link, $this->username);
      $email = mysqli_real_escape_string($link, $this->email);
      $fname = mysqli_real_escape_string($link, $this->first_name);
      $lname = mysqli_real_escape_string($link, $this->last_name);
      $password = $this->password;
      $avatar = $this->avatar;
      $status = $this->status;
      $signature = mysqli_real_escape_string($link, $this->signature);

      $sql = new SQL($link, "UPDATE users (username, password, first_name, last_name, email, avatar, status, signature)
        VALUES ('$user', '$password', '$fname', '$lname', '$email', '$avatar', '$status', '$signature')");

      return $sql->is_ok();
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
        new SQL($link, "UPDATE users SET last_entry = '".sql_time(time())."' WHERE id = '$this->id'");
      }
    }

    function is_manager($link, $forum_id) {
      if (isset($_SESSION["$forum_id-manager"])) return true;
      $managers = Forum::getManagers($link, $forum_id);
      while ($manager_id = $managers->result()['id']) {
        if ($this->id == $manager_id) {
          $_SESSION["$forum_id-manager"] = true;
          return true;
        }
      }
      return false;
    }
  }

?>