<?php
    namespace App\Controllers;
    
    use App\Controller;
    use App\Request;
    use App\Session;

    class PostController extends Controller{

        public function __construct(Request $request,Session $session){
            parent::__construct($request,$session);
        }

        public function index(){
                //posts list for user

                //$post=$this->selectAll();
                $this->render();
        }

        public function new(){
            $user=$this->session->get('user');
            $this->render(['user'=>$user],'newpost');
        }

        public function add(){
            // data from post
            $id=$this->session->get('user')['id'];
            $db=$this->getDB();
            if($db->insert('tasks',['description'=>$description,'user'=>$id,'due_date'=>$datetime])){
                header('Location:'.BASE.'user/dashboard');
            }else{
                header('Location:'.BASE.'task/new');
            }
        }
        public function edit($id){
            $user=$this->session->get('user');
            $task=$this->getDB()->selectWhereWithJoin('tasks','users',
                ['tasks.description'],'tasks.user','users.id',['tasks.id'=>$id]);
            $this->render(['user'=>$user],'edittask');
        
        }
        public function update(){
            $data =(array) json_decode(stripslashes($_POST['data']));
            
            try{
                $res=$this->getDB()->update('tasks',$data,['id',$data['id']]);
            }catch(\Exception $e){
                return ($e->getMessage());
            }
           return $res;
        }
        
        public function remove(){
            //recollim dades passades per ajax
            $id=$_POST['id'];
            $user=$this->session->get('user');
            $this->getDB()->remove('tasks',$id);
        }
    }
