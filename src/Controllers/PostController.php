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
            try{
                $db->beginTransaction();
                $db->insert('posts',
                ['title'=>$title,
                'body'=>$body,
                'editor'=>$editor,
                'createdAt'=>$createdAt]);
                $post=$db->lastInsertId();
                foreach($ar_tag as $tag){
                    $db->insert('tags',['name'=>$tag]);
                    $idtag=$db->lastInsertId();
                    $sql="INSERT INTO 'posts_has_tags' VALUES(?,?)";
                    $stmt=$db->prepare($sql);
                    $stmt->bindValue(1, $post, \PDO::PARAM_INT);
                    $stmt->bindValue(2, $idtag, \PDO::PARAM_INT);
                    $stmt->execute();
                    //$db->insert('posts_has_tags',['post'=>$post,'tag'=>$idtag]);
                   //var_dump('')
                }
                $db->commit();
                header('Location:'.BASE.'user/dashboard');
            }
            catch(\PDOException $e){
                $db->rollBack();
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
            $this->getDB()->remove('tasks',$id);
        }
        public function show(){
            $params=$this->request->getParams();
            
            $post=$this->getDB()->selectWhere('posts',['title','body'],$params);
            $this->render(['data'=>$post],'showpost');
            
        }

        
    }
