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
    private $isDeleted = false;
    
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
        }
    }

    function deletePost(){
        //update value
        $this->isDeleted = 1; 
 
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET 
            is_deleted = {$this->isDeleted}
            WHERE id = {$this->_id};");

        return $sql->is_ok();
    }

    function editPost($title = null, $content = null, $authorId = null, $forumId = null, $postId = null, $isPinned = null, $isLocked = null){
        //update values
        $this->title = $title != null ? $title : $this->title;
        $this->content = $content != null ? $content : $this->content;
        $this->authorId = $authorId != null ? $authorId : $this->authorId;
        $this->forumId = $forumId != null ? $forumId : $this->forumId;
        $this->postId = $postId != null ? $postId : $this->postId;
        $this->isPinned = $isPinned != null ? ($isPinned ? 1 : 0) : $this->isPinned;
        $this->isLocked = $isLocked != null ? ($isLocked ? 1 : 0) : $this->isLocked; 
        
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET title = {$this->title}, content = {$this->content}, author_id = {$this->authorId}, forum_id = {$this->forumId}, is_pinned = {$this->isPinned}, is_locked = {$this->isLocked}, edit_time = {sql_time(time())}
        WHERE id = {$this->_id};");

        return $sql->is_ok();
    }

    function changePinnedPost($isPinned){
        //update values 
        $this->isPinned = $isPinned ? 1 : 0;
        
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET 
        is_pinned = {$this->isPinned}
        WHERE id = {$this->_id};");

        return $sql->is_ok();
    }

    function changeLockedPost($isLocked){
        //update values 
        $this->isLocked = $isLocked ? 1 : 0;
                
        $sql = new SQL($this->_DB, "UPDATE {$this->table} SET is_locked = {$this->isLocked}
            WHERE id = {$this->_id};");

        return $sql->is_ok();
    }


    // function sendQuery($query){
        
    //     //this is here for debugging
    //     // echo "<pre>";
    //     // print_r($this->_DB);
    //     // echo "</pre>";
    //     // echo "</br> insertet query is : " .$query ."</br>";
    //     //echo "</br>".mysqli_real_escape_string ($this->_DB, $query);

    //     if (mysqli_query($this->_DB, $query)) {
    //         echo "YAY";
    //     }else{
    //         echo "<br>".mysqli_error($this->_DB);
    //     }
    // }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
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

    function getPostId() {
        return $this->postId;
    }

    function isPinned() {
        return $this->isPinned;
    }

    function isLocked() {
        return $this->isLocked;
    }

    function isDeleted() {
        return $this->isDeleted;
    }
}
?>