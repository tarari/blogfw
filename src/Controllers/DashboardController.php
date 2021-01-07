<?php
    namespace App\Controllers;

        use App\Request;
        use App\Session;
        use App\Controller;

    final class DashboardController extends Controller{
    
        public function __construct(Request $request,Session $session){
            parent::__construct($request,$session);
        }
        
        public function index(){
            $db=$this->getDB();
            $posts=$db->selectAll('posts');
            $this->render(['data'=>$posts],'gdashboard');
        }
        
    }