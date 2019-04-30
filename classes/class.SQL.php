<?php
  class SQL {
    
    private $id = null;
    private $q = '';
    private $sql = '';
    private $ok = false;
    private $rows_updated = 0;

    function __construct($link, $q) {
      $this->q = trim(strtolower($q));
      $this->sql = mysqli_query($link, $q);
      $this->rows_updated = mysqli_affected_rows($link);
      if (!$this->sql) {
        $error = mysqli_error($link);
        echo $q."<br/>";
        echo $error;
        mysqli_query($link, "INSERT INTO queries (query, error) VALUES ('$q', '$error')");
      } else {
        $this->ok = true;
        $this->id = mysqli_insert_id($link);
      }
    }

    function rows_updated() {
      return $this->rows_updated;
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

    function getQ() {
      return $this->q;
    }
  }
?>