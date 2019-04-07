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
    private $lastActivity = null;
    
    private $_id = null;
    private $table = "posts";

    static function from_sql($db, $result) {
        return new Post($db, $result['title'], $result['content'], $result['author_id'], $result['last_activity'], $result['creation_time'], $result['edit_time'], $result['forum_id'], $result['post_id'], $result['is_pinned'], $result['is_locked'], $result['id']);
    }

    static function from_id($db, $id) {
        $sql = new SQL($db, "SELECT * FROM posts WHERE id = $id");
        if ($sql->is_ok()) {
            return Post::from_sql($db, $sql->result());
        }
        return null;
    }
   
    function __construct($db, $title, $content, $authorid, $lastActivity = null, $creationTime = null, $editTime = null, $forumId = null, $postId = null, $isPinned = 0, $isLocked = 0, $id = null) {
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
        $this->lastActivity = null;
    }
    
    function addToDb() {
        $sql = new SQL($this->_DB, "INSERT INTO {$this->table} (title, content, author_id, forum_id, post_id, is_pinned, is_locked, last_activity) 
          VALUES ('{$this->title}','{$this->content}', '{$this->authorId}', '{$this->forumId}', '{$this->postId}', {$this->isPinned}, {$this->isLocked}, {($this->lastActivity ? sql_time($this->lastActivity) : null)});");

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
        
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET title = {$this->title}, content = {$this->content}, author_id = {$this->authorId}, forum_id = {$this->forumId}, is_pinned = {$this->isPinned}, is_locked = {$this->isLocked}, edit_time = {sql_time(time())}
        WHERE id = {$this->_id};");

        return $sql->is_ok();
    }

    function showPosts($pinned = false) {
        $posts_sql = new SQL($this->_DB, "SELECT * FROM posts WHERE post_id = $this->_id AND is_pinned = ".($pinned ? 1 : 0));
        if (!$posts_sql->is_ok()) return false;
        while ($post = $posts_sql->result()) {
            $post = Post::from_sql($this->_DB, $post);
            $sql = new SQL($this->_DB, "SELECT username FROM users WHERE id = {$post->getAuthorId()}");
            if (!$sql->is_ok()) return false;
            $author = $sql->result()['username'];
            $is_topic = false;
            include "templates/post.php";
        }
    }

    private function post($posts_sql) {

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
}
?>