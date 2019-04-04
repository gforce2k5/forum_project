<?php
  class SQL {
    
    private $id = null;
    private $q = '';
    private $sql = '';
    private $ok = false;

    function __construct($link, $q) {
      mysqli_query($link, "SET NAMES utf8");
      // echo "<h1>$q</h1>";
      $this->q = trim(strtolower($q));
      $this->sql = mysqli_query($link, $q);
      if (!$this->sql) echo mysqli_error($link);
      else {
        $this->ok = true;
        $this->id = mysqli_insert_id($link);
      }
    }

    function rows() {
      if ($this->ok && $this->is_select()) {
        return $this->sql->num_rows;
      }
      return null;
    }

    function result() {
      if ($this->ok && $this->is_select() && $result = mysqli_fetch_assoc($this->sql)) return $result;
      return false;
    }

    function get_id() {
      return $this->id;
    }

    private function is_select() {
      return strpos($this->q, 'select') === 0;
    }

    function is_ok() {
      return $this->ok;
    }
  }
?>