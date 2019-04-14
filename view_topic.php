<?php
  $page_title = "View Topic";
  require_once "header.php";
  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $topic_id = intval($_GET['p']);
    $topic = Post::from_id($link, $topic_id);
    $forum = null;
    if ($topic) {
      $q = "SELECT id, name FROM categories WHERE id = (SELECT cat_id FROM forums WHERE id = ";
      if ($p = $topic->getForumId()) {
        $q .= $p.")";
        $forum = Forum::from_id($link, $p);
      } elseif ($p = $topic->getPostId()) {
        $sq = "SELECT forum_id FROM posts WHERE id = $p";
        $sql = new SQL($link, $sq);
        if ($sql->is_ok()) {
          $forum = Forum::from_id($link, $sql->result()['forum_id']);
        }
        $q .= "($sq))";
      }

      $e_id = null;
      if (is_logged_in() && isset($_GET['e']) && is_numeric($_GET['e'])) {
        $e_id = intval($_GET['e']);
        $query = "SELECT id FROM posts WHERE id = $e_id";
        if ($current_user->get_status() != 2 && !is_manager($link, $current_user->get_id(), $forum->get_id()))
          $query .= " AND author_id = {$current_user->get_id()}";
        $sql = new SQL($link, $query);
        if (!$sql->is_ok() || $sql->rows() == 0) {
          $e_id = null;
        }
      }
      // print_array($topic);
      $sql = new SQL($link, $q);
      if ($sql->is_ok() && $forum) {
        $result = $sql->result();
        $cat_name = $result['name'];
        $cat_id = $result['id'];
        include "templates/view_topic.php";
      }
    } else {
      $error_msg = 'חלה שגיאה';
      $alert_type = 'warning';
      include "templates/alert.php";
    }
  }

  require_once "footer.php";
?>