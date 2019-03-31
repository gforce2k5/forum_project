<?php
class Post{
    private $_DB = null;
    private $title = null;
    private $content = null;
    private $authorId = null;
    private $forumId = null;
    private $isPinned = null;
    private $isLocked = null;
    private $isDeleted = false;
    
    private $_id = null;
    private $table = "posts";

   
    function __construct($db, $tile, $content, $authorid, $forumId, $isPinned = 0, $isLocked = 0){
        //save values 
        $this->_DB = $db;
        $this->title = $tile;
        $this->content = $content;
        $this->authorId = $authorid;
        $this->forumId = $forumId;
        $this->isPinned = $isPinned ? 1 : 0;
        $this->isLocked = $isPinned ? 1 : 0; 
      
        $sql = "INSERT INTO {$this->table} (title, content, author_id, forum_id, is_pinned, is_locked) 
        VALUES ('{$this->title}','{$this->content}', '{$this->authorId}', '{$this->forumId}', {$this->isPinned}, {$this->isLocked});";

        $this->sendQuery($sql);

        $this->_id = mysqli_insert_id($this->_DB);
    }

    function deletePost(){
        //update value
        $this->isDeleted = 1; 
 
        $sql = "UPDATE {$this->table} SET 
        is_deleted = {$this->isDeleted}
        WHERE id = {$this->_id};";

        $this->sendQuery($sql);
    }

    function editPost($title = null, $content = null, $authorId = null, $forumId = null, $isPinned = null, $isLocked = null){
        //update values
        $this->title = $title != null ? $title : $this->title;
        $this->content = $content != null ? $content : $this->content;
        $this->authorId = $authorId != null ? $authorId : $this->authorId;
        $this->forumId = $forumId != null ? $forumId : $this->forumId;
        $this->isPinned = $isPinned != null ? ($isPinned ? 1 : 0) : $this->isPinned;
        $this->isLocked = $isLocked != null ? ($isLocked ? 1 : 0) : $this->isLocked; 
        
        $sql = "UPDATE {$this->table} SET title = {$this->title}, content = {$this->content}, author_id = {$this->authorId}, forum_id = {$this->forumId}, is_pinned = {$this->isPinned}, is_locked = {$this->isLocked}
        WHERE id = {$this->_id};";

        $this->sendQuery($sql);
    }

    function changePinnedPost($isPinned){
        //update values 
        $this->isPinned = $isPinned ? 1 : 0;
        
        $sql = "UPDATE {$this->table} SET 
        is_pinned = {$this->isPinned}
        WHERE id = {$this->_id};";

        $this->sendQuery($sql);
    }

    function changeLockedPost($isLocked){
        //update values 
        $this->isLocked = $isLocked ? 1 : 0;
                
        $sql = "UPDATE {$this->table} SET 
        is_locked = {$this->isLocked}
        WHERE id = {$this->_id};";

        $this->sendQuery($sql);
    }


    function sendQuery($query){
        
        //this is here for debugging
        // echo "<pre>";
        // print_r($this->_DB);
        // echo "</pre>";
        // echo "</br> insertet query is : " .$query ."</br>";
        //echo "</br>".mysqli_real_escape_string ($this->_DB, $query);

        if (mysqli_query($this->_DB, $query)) {
            echo "YAY";
        }else{
            echo "<br>".mysqli_error($this->_DB);
        }
    }

}
?>