<?php

    class SessionManager{
        private $name = "";
        private $value = "";



        function __construct($name, $value, $toDestroy = true){
            $this->name = $name;
            $this->value = $value;

            if(isset($_SESSION[$value])){
                if($toDestroy){
                   create_session();
                }
            }else{
               create_session();
            }
        }

        function create_session(){
            $_SESSION[$this->name] = $this->value;
        }

        function is_cookies_enabled(){
            setcookie("test", 1, time()+3600, '/');
            return count($_COOKIE)>0; 
        }

        function start_session(){
            //activate before <html>
            session_start();
        }

        function end_session(){
            //activare after <html>
            session_unset();
            session_destroy();
        }

    }

?>