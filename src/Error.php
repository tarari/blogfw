<?php

    namespace App;

    use \Exception;

    final class Error extends Exception{
        function __construct(){
            parent::__construct($message);
        }
        function getError(){
            return $this->getMessage();
        }

    }