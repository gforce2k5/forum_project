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
   
    function __construct($db, $title, $content, $authorid, $creationTime = null, $editTime = null, $forumId = null, $postId = null, $isPinned = 0, $isLocked = 0) {
        //save values 
        $this->_DB = $db;
        $this->title = mysqli_real_escape_string($db, $title);
        $this->content = mysqli_real_escape_string($db, $content);
        $this->authorId = mysqli_real_escape_string($db, $authorid);
        $this->forumId = mysqli_real_escape_string($db, $forumId);
        $this->postId = myslqi_real_escape_string($db, $postId);
        $this->isPinned = $isPinned ? 1 : 0;
        $this->isLocked = $isLocked ? 1 : 0; 
        $this->creationTime = $creationTime;
        $this->editTime = $editTime;
    }
    
    function addToDb() {
        $sql = new SQL($this->_DB, "INSERT INTO {$this->table} (title, content, author_id, forum_id, post_id, is_pinned, is_locked) 
          VALUES ('{$this->title}','{$this->content}', '{$this->authorId}', '{$this->forumId}', '{$this->post_id}', {$this->isPinned}, {$this->isLocked});");

        if ($sql->ok()) {
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