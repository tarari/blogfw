<?php

    namespace App;
    

    class FormBuilder
    {
        private $elements = array();

        public function open($uri,$method=null){
            $method=$method??'POST';
            $this->elements[]="<form method=\"$method\" action=\"$uri\" >";
            return $this;
        }
        public function close(){
            $this->elements[]="</form>";
            return $this;
        }

        public function label($text) {
            $this->elements[] = "<label >$text</label>";
            return $this;
        }   

        public function input($type,$name,$attr=null) {
            $value=$value??'';
            $str='';
            if(is_array($attr)){
                foreach($attr as $key=>$value){
                    $str.="{$key}='{$value}' ";
                }
            }
            $this->elements[] = "<input type=\"$type\" {$str}  name=\"$name\"   />";
            return $this;
        }   

        public function textarea($name, $id, $value =null) {
            $value=$value??'';
            $this->elements[] = "<textarea name=\"$name\" id=\"$id\" >$value</textarea>";
            return $this;
        }
        public function submit($value=null){
            $value=$value??'Next';
            $this->elements[] ="<button type=\"submit\" class=\"btn btn-primary m-4\">$value</button>";
            return $this;
        }
        public function csrf($value){
            $this->elements[]="<input type=\"hidden\" name=\"csrf-token\" value=\"$value\">";
           
            return $this;
        }
        /**
         * Returns string when form is completed
         *
         * @return string
         */
        public function __toString() {
            return join("\n", $this->elements);
        }   
    }
