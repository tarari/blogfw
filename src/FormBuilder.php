<?php

    namespace App;
    use App\FormFieldsBuilder;

    class FormBuilder
    {
        private $elements = array();

        public function label($text) {
            $this->elements[] = "<label >$text</label>";
            return $this;
        }   

        public function input($type, $name, $value = '') {
            $this->elements[] = "<input type=\"$type\" class=\"form-control\" name=\"$name\" value=\"$value\" />";
            return $this;
        }   

        public function textarea($name, $value = '') {
            $this->elements[] = "<textarea name=\"$name\">$value</textarea>";
            return $this;
        }   

        public function __toString() {
            return join("\n", $this->elements);
        }   
    }
