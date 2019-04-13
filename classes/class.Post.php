<?php
class Post{
    private $_DB = null;
    private $title = null;
    private $content = null;
    private $creationTime = null;
    private $authorId = null;
    private $editTime = null;
    private $forumId = null;
    private $postId = null;
    private $isPinned = null;
    private $isLocked = null;
    
    private $_id = null;
    private $table = "posts";

    static function from_sql($db, $result) {
        return new Post($db, $result['title'], $result['content'], $result['author_id'], $result['creation_time'], $result['edit_time'], $result['forum_id'], $result['post_id'], $result['is_pinned'], $result['is_locked'], $result['id']);
    }

    static function from_id($db, $id) {
        $sql = new SQL($db, "SELECT * FROM posts WHERE id = $id");
        if ($sql->is_ok()) {
            return Post::from_sql($db, $sql->result());
        }
        return null;
    }
   
    function __construct($db, $title, $content, $authorid, $creationTime = null, $editTime = null, $forumId = null, $postId = null, $isPinned = 0, $isLocked = 0, $id = null) {
        //save values 
        $this->_DB = $db;
        $this->title = mysqli_real_escape_string($db, $title);
        $this->content = mysqli_real_escape_string($db, $content);
        $this->authorId = mysqli_real_escape_string($db, $authorid);
        $this->forumId = mysqli_real_escape_string($db, $forumId);
        $this->postId = mysqli_real_escape_string($db, $postId);
        $this->isPinned = $isPinned ? 1 : 0;
        $this->isLocked = $isLocked ? 1 : 0; 
        $this->creationTime = $creationTime;
        $this->editTime = $editTime;
        $this->_id = $id;
    }
    
    function addToDb() {
        $forumId = $this->forumId ? "'$this->forumId'" : "NULL";
        $postId = $this->postId ? "'$this->postId'" : "NULL";
        $sql = new SQL($this->_DB, "INSERT INTO {$this->table} (title, content, author_id, forum_id, post_id, is_pinned, is_locked) 
          VALUES ('{$this->title}','{$this->content}', '{$this->authorId}', {$forumId}, {$postId}, {$this->isPinned}, {$this->isLocked});");

        if ($sql->is_ok()) {
            $this->_id = $sql->get_id();
            return true;
        }
        return false;
    }

    function deletePost(){
        //update value

        $sql = new SQL($this->_DB, "DELETE FROM posts WHERE id = $this->id LIMIT 1");
        if ($sql->is_ok()) {
            $sql = new SQL($this->_DB, "DELETE FROM posts WHERE post_id = $this->id");
            return $sql->is_ok();
        }

        return false;
    }

    function editDB(){
        //update values
        $forumId = $this->forumId ? "'{$this->forumId}'" : "NULL";
        $postId = $this->postId ? "'{$this->postId}'" : "NULL";
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET title = '{$this->title}', content = '{$this->content}', author_id = {$this->authorId}, post_id = {$postId}, forum_id = {$forumId}, is_pinned = {$this->isPinned}, is_locked = {$this->isLocked} WHERE id = {$this->_id};");
        print_array(mysqli_error_list($this->_DB));
        return $sql->is_ok();
    }

    function showPosts($pinned = false) {
        global $classes, $current_user;
        $posts_sql = new SQL($this->_DB, "SELECT * FROM posts WHERE post_id = $this->_id AND is_pinned = ".($pinned ? 1 : 0));
        if (!$posts_sql->is_ok()) return false;
        $counter = 1;
        while ($post = $posts_sql->result()) {
            $post = Post::from_sql($this->_DB, $post);
            $sql = new SQL($this->_DB, "SELECT id, username, register_date FROM users WHERE id = {$post->getAuthorId()}");
            if (!$sql->is_ok()) return false;
            $result = $sql->result();
            $author = $result['username'];
            $register_date = $result['register_date'];
            $is_topic = false;
            $bb_parser = new bbParser();
            include "templates/post.php";
            $counter++;
            if ($counter == 2) $counter = 0;
        }
    }

    function getId() {
        return $this->_id;
    }

    function getTitle() {
        return $this->title;
    }

    function setTitle($value) {
        $this->title = $value;
    }

    function getContent() {
        return $this->content;
    }

    function setContent($value) {
        $this->content = $value;
    }

    function getCreationTime() {
        return $this->creationTime;
    }

    function getAuthorId() {
        return $this->authorId;
    }

    function getEditTime() {
        return $this->editTime;
    }

    function getForumId() {
        return $this->forumId;
    }

    function setForumId($value) {
        $this->forumId = $value;
    }

    function getPostId() {
        return $this->postId;
    }

    function isPinned() {
        return $this->isPinned;
    }

    function pinPost() {
        $this->isPinned = true;
    }

    function unpinPost() {
        $this->isPinned = false;
    }

    function isLocked() {
        return $this->isLocked;
    }

    function lockPost() {
        $this->isLocked = true;
    }

    function unlockPost() {
        $this->isLocked = false;
    }

    function updateActivity() {
        new SQL($this->_DB, "UPDATE posts SET last_activity = NOW() WHERE id = $this->_id");
    }
}
?>