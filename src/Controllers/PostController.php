<?php
    namespace App\Controllers;
    
    use App\Controller;
    use App\FormBuilder;
    use App\Request;
    use App\Session;

    class PostController extends Controller{

        public function __construct(Request $request,Session $session){
            parent::__construct($request,$session);
        }

        public function index(){
                //post list for user

                //$posts=$this->select('posts');
                $this->render();
        }

        public function new(){
            $user=$this->session->get('user');
            $form=new FormBuilder();
            $form->open(BASE.'post/add')
                ->label('Title')
                ->input('text','title')
                ->label('Contents')
                ->textarea('body','editor')
                ->submit('Add post')
                ->close();
           // $form->label('username')->input('username');
            $this->render(['user'=>$user,'form'=>$form],'newpost');
        }

        public function add(){
            $title=filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
            $body=filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING);
            $createdAt=date('Y-m-d H:i:s', time());
            $editor=$this->session->get('user')['id'];
            
            $db=$this->getDB();
            if($db->insert('posts',['title'=>$title,'body'=>$body,'editor'=>$editor,'createdAt'=>$createdAt])){
                header('Location:'.BASE.'user/dashboard');
            }else{
                header('Location:'.BASE.'post/new');
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
        public function show(){
            $params=$this->request->getParams();
            
            $post=$this->getDB()->selectWhere('posts',['title','body'],$params);
            $this->render(['data'=>$post],'showpost');
            
        }

        
    }
