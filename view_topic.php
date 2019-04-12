<?php
  $page_title = "View Topic";
  require_once "header.php";

  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $topic_id = intval($_GET['p']);
    $topic = Post::from_id($link, $topic_id);
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