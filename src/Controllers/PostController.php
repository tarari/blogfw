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
                ->input('text','title',['class'=>'form-control mb-3'])
                ->label('Contents')
                ->textarea('body','editor')
                ->label('tags')
                ->input('text','tags',['class'=>'form-control mb-3','data-role'=>'tagsinput'])
                ->submit('Add post')
                ->close();
           // $form->label('username')->input('username');
            $this->render(['user'=>$user,'form'=>$form],'newpost');
        }

        public function add(){
            $title=filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
            $body=filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING);
            $createdAt=date('Y-m-d H:i:s', time());
            $tags=filter_input(INPUT_POST,'tags',FILTER_SANITIZE_STRING);
            
            $editor=$this->session->get('user')['id'];
            
            if($tags!=""){
                $ar_tag=explode(',',$tags);
                }
            $db=$this->getDB();
           // $db->beginTransaction();
            try{
                
                $db->insert('posts',
                ['title'=>$title,
                'body'=>$body,
                'user'=>$editor,
                'createdAt'=>$createdAt]);
                $post=$db->lastInsertId();
                var_dump($post);
                foreach($ar_tag as $tag){
                    try{
                       // $db->beginTransaction();
                        $db->insert('tags',['name'=>$tag]);
                        $idtag=$db->lastInsertId();
                        var_dump($idtag);
                        
                        $db->insert('posts_has_tags',['tag'=>$idtag,'post'=>$post]);
//$db->commit();
                    }catch(\PDOException $e){
                        echo $e->getMessage();
                    }
                }
                
                header('Location:'.BASE.'user/dashboard');
            }
            catch(\PDOException $e){
        
                header('Location:'.BASE.'post/new');
            }
            
           
               
           
        }
        public function edit($id){
            $user=$this->session->get('user');
            $task=$this->getDB()->selectWhereWithJoin('posts','users',
                ['posts.body'],'tasks.user','users.id',['tasks.id'=>$id]);
            $this->render(['user'=>$user],'edittask');
        
        }
        public function update(){
            $data =(array) json_decode(stripslashes($_POST['data']));
            
            try{
                $res=$this->getDB()->update('posts',$data,['id',$data['id']]);
            }catch(\Exception $e){
                return ($e->getMessage());
            }
           return $res;
        }
        
        public function remove(){
            //recollim dades passades per ajax
            $id=$_POST['id'];
            $user=$this->session->get('user');
            $this->getDB()->remove('posts',$id);
        }
        public function show(){
            $params=$this->request->getParams();
            
            $post=$this->getDB()->selectWhere('posts',['title','body'],$params);
            $this->render(['data'=>$post],'showpost');
            
        }

        
    }
