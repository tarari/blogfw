<?php
    namespace App\Controllers;

        use App\Request;
        use App\Session;
        use App\Controller;

    final class IndexController extends Controller{

        public function __construct(Request $request,Session $session){
            parent::__construct($request,$session);
        }
        
        public function index(){
            $db=$this->getDB();
            $data=$db->selectAll('posts');
            
            $user=$this->session->get('user');
            $dataview=[ 'title'=>'Bloggy','user'=>$user,
                         'data'=>$data];
            $this->render($dataview);
        }
       
        
    }