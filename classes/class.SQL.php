<?php
  class SQL {
    
    private $q = '';
    private $sql = '';
    private $ok = false;

    function __construct($link, $q) {
      $this->q = trim(strtolower($q));
      $this->sql = mysqli_query($link, $q);
      if (!$this->sql) echo mysqli_error($link);
      else $this->ok = true;
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

    private function is_select() {
      return strpos($this->q, 'select') === 0;
    }

    function is_ok() {
      return $this->ok;
    }
  }
?>