<?php
  class Forum {
    private $id = null;
    private $name = null;
    private $description = '';
    private $create_date = null;
    private $cat_order = '';
    private $cat_id = null;
    private $active = true;

    static function from_id($link, $id) {
      $sql = new SQL($link, "SELECT * FROM forums WHERE id = $id");
      if ($sql->is_ok() && $sql->rows() == 1) {
        $res = $sql->result();
        return new Forum($res['name'], $res['description'], $res['cat_id'], $res['id'], $res['create_date'], $res['cat_order'], $res['active']);
      }
    }

    function __construct($name, $description, $cat_id, $id = null, $create_date = null, $cat_order = '', $active = true) {
      $this->name = $name;
      $this->description = $description;
      $this->create_date = $create_date ? $create_date : $this->create_date;
      $this->cat_id = $cat_id;
      $this->cat_order = $cat_order;
      $this->active = $active;
      $this->id = $id;
    }

    function add_to_db($link) {
      $name = mysqli_real_escape_string($link, $this->name);
      $description = mysqli_real_escape_string($link, $this->description);
      $cat_id = mysqli_real_escape_string($link, $this->cat_id);
      $cat_order = mysqli_real_escape_string($link, $this->cat_order);
      $active = mysqli_real_escape_string($link, $this->active);

      $sql = new SQL($link, "SELECT id FROM forums WHERE name = '$name'");

      if ($sql->is_ok() && $sql->rows() >= 1) return false;

      $sql = new SQL($link, "INSERT INTO forums SET name = '$name', description = '$description', cat_id = '$cat_id', cat_order = '$cat_order', active = '$active'");

      if (!$sql->is_ok()) {
        return false;
      }

      $this->id = $sql->get_id();
      return true;
    }

    function get_name() {
      return $this->name;
    }

    function set_name($value) {
      $this->name = $value;
    }

    function get_id() {
      return $this->id;
    }

    function get_description() {
      return $this->description;
    }

    function set_description($value) {
      $this->description = $value;
    }

    function get_create_date() {
      return $this->create_date;
    }

    function get_cat_order() {
      return $this->cat_order;
    }

    function set_cat_order($value) {
      $this->cat_order = $value;
    }

    function get_cat_id() {
      return $this->cat_id;
    }

    function set_cat_id($value) {
      $this->cat_id = $value;
    }

    function is_active() {
      return $this->active;
    }

    function set_active($active) {
      $this->active = $active;
    }

    function show_posts($link, $pinned = false) {
      $forum_sql = new SQL($link, "SELECT * FROM posts WHERE forum_id = '$this->id' AND is_pinned = '".($pinned ? 1: 0)."' ORDER BY last_activity DESC");
      if (!$forum_sql->is_ok()) return false;
      while ($topic = $forum_sql->result()) {
        $topic = Post::from_sql($link, $topic);
        $sql = new SQL($link, "SELECT username FROM users WHERE id = ".$topic->getAuthorId());
        if (!$sql->is_ok()) return false;
        $author = $sql->result()['username'];
        $sql = new SQL($link, "SELECT count(id) as cnt FROM posts WHERE post_id = ".$topic->getId());
        if (!$sql->is_ok()) return false;
        $post_count = $sql->result()['cnt'];
        $sql = new SQL($link, "SELECT max(creation_time) as last_reply FROM posts WHERE post_id = {$topic->getId()}");
        if (!$sql->is_ok()) return false;
        $last_reply_time = $sql->result()['last_reply'];
        if ($last_reply_time) {
          $sql = new SQL($link, "SELECT username FROM users WHERE id = (SELECT author_id FROM posts WHERE post_id = '{$topic->getId()}' AND creation_time = '$last_reply_time')");
          if (!$sql->is_ok()) return false;
          $last_username = $sql->result()['username'];
        }
        include(SITE_ROOT."/../templates/topic_cube.php");
      }
    }
  }
?>