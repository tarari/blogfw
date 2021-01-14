<?php
    namespace App\Controllers;

        use App\Request;
        use App\Session;
        use App\Controller;

        final class ErrorController extends Controller{
            protected $msg;
            public function __construct(String $msg){
                
                $this->render(['msg'=>$msg],'error');
            }
        }