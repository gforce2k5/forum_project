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
      global $classes;
      $cat_sql = new SQL($link, "SELECT * FROM forums WHERE cat_id = $this->id ORDER BY cat_order ASC");
      if ($cat_sql->is_ok()) {
        $counter = 0;
        while ($forum = $cat_sql->result()) {
          $sql = new SQL($link, "SELECT count(id) AS cnt FROM posts WHERE forum_id = {$forum['id']}");
          if (!$sql->is_ok()) {
            return false;
          }
          $topic_count = $sql->result()['cnt'];
          $sql = new SQL($link, "SELECT count(p1.id) AS cnt FROM posts AS p1 JOIN posts AS p2 ON p1.post_id = p2.id AND p2.forum_id = {$forum['id']}");
          if (!$sql->is_ok()) {
            return false;
          }
          $post_count = $sql->result()['cnt'];

          $sql = new SQL($link, "SELECT * FROM posts WHERE forum_id = {$forum['id']} ORDER BY creation_time DESC LIMIT 1");
          // $sql = new SQL($link, "SELECT GREATEST(max(p1.creation_time), max(p2.creation_time)) AS time FROM posts AS p1 JOIN posts AS p2 ON p2.post_id = p1.id AND p1.forum_id = {$forum['id']};");
          if (!$sql->is_ok()) return false;
          
          if ($sql->rows() > 0) {
            $last_post = Post::from_sql($link, $sql->result());
            
            $sql = new SQL($link, "SELECT username FROM users WHERE id = {$last_post->getAuthorId()}");

            $username = $sql->result()['username'];
            if (!$sql->is_ok()) {
              return false;
            }
          }
          $cat_name = $this->name;
          $cat_id = $this->id;
          include SITE_ROOT."/../templates/forum.php";
          $counter++;
          if ($counter == 2) $counter = 0;
        }
      }
    }

    function get_id() {
      return $this->id;
    }

    function get_name() {
      return $this->name;
    }

    function set_name($value) {
      $this->name = $value;
    }

    function get_cat_order() {
      return $this->cat_order;
    }

    function set_cat_order($value) {
      $this->cat_order = $value;
    }

    function is_active() {
      return $this->active;
    }
  }

?>