<?php
  class Cookie {
    private $name = '';
    private $value = '';
    private $expire = 0;

    function __construct($name, $value, $expire) {
      $this->name = $name;
      $this->value = $value;
      $this->extend($expire, false);
    }

    function exists() {
      return isset($_COOKIE[$this->name]);
    }

    function set() {
      return setcookie($this->name, $this->value, $this->expire);
    }

    function change($value) {
      $this->value = $value;
      if ($this->exists()) return $this->set();
      return false;
    }

    function get() {
      if ($this->exists()) {
        $this->value = $_COOKIE[$this->name];
        return $this->value;
      }

      return null;
    }

    function extend($expire, $set = true) {
      $this->expire = time() + $expire * 24 * 60 * 60;
      if ($set && $this->exists()) return $this->set();
      return false;
    }

    function unset() {
      $this->expire = 1;
      $this->value = '';
      if ($this->exists()) return $this->set();
      return false;
    }

  }
?>