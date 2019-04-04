<?php

  class Category {
    private $id = null;
    private $name = '';
    private $cat_order = null;
    private $active = true;

    static function show_category_list($link) {
      $sql = new SQL($link, "SELECT name, id FROM categories");
      if (!$sql->is_ok()) return false;
      $html = '';
      while ($cat = $sql->result()) {
        $html .= '<option value="'.$cat['id'].'">'.sanitize_input($cat['name']).'</option>';
      }
      return $html;
    }

    static function category_from_sql($sql_result) {
      return new Category($sql_result['name'], $sql_result['cat_order'], $sql_result['active'], $sql_result['id']);
    }

    function __construct($name, $cat_order = null, $active = true, $id = null) {
      $this->name = $name;
      $this->cat_order = $cat_order;
      $this->active = $active;
      $this->id = $id;
    }

    function add_to_db($link) {
      $name = mysqli_real_escape_string($link, $this->name);
      $cat_order = mysqli_real_escape_string($link, $this->cat_order);
      $active = mysqli_real_escape_string($link, $this->active);
      $sql = new SQL($link, "SELECT id FROM categories WHERE name = '$name'");

      if($sql->is_ok() && $sql->rows() >= 1) return false;

      $sql = new SQL($link, "INSERT INTO categories (name, cat_order, active) VALUES('$name', '$cat_order', '$active')");

      if ($sql->is_ok()) {
        $this->id = $sql->get_id();
      }
      return true;
    }

    function display_forums($link) {
      $cat_sql = new SQL($link, "SELECT * FROM forums WHERE cat_id = $this->id ORDER BY cat_order ASC");
      if ($cat_sql->is_ok()) {
        while ($forum = $cat_sql->result()) {
          $sql = new SQL($link, "SELECT count(id) AS cnt FROM posts WHERE forum_id = {$forum['id']}");
          if (!$sql->is_ok()) {
            return false;
          }
          $topic_count = $sql->result()['cnt'];
          $sql = new SQL($link, "SELECT count(id) AS cnt FROM posts WHERE post_id = 
            (SELECT id FROM posts WHERE forum_id = $this->id)");
          if (!$sql->is_ok()) {
            return false;
          }
          $post_count = $sql->result()['cnt'];

          $sql = new SQL($link, "SELECT username FROM users WHERE id =
            (SELECT author_id FROM posts WHERE creation_time = 
              (SELECT max(creation_time) FROM posts WHERE forum_id = '$this->id'))");

          if (!$sql->is_ok()) {
            return false;
          }

          $username = $sql->result()['username'];
          include SITE_ROOT."/../templates/forum.php";
        }
      }
    }

    function get_id() {
      return $this->id;
    }

    function get_name() {
      return $this->name;
    }

    function get_cat_order() {
      return $this->cat_order;
    }

    function is_active() {
      return $this->active;
    }
  }

?>