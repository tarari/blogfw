<?php

    namespace App\Controllers;
    
    use App\Controller;
    use App\Session;
    use App\Request;

    class UserController extends Controller
    {
        public function __construct(Request $request,Session $session){
            parent::__construct($request,$session);
        }
       
       //funcions de render
        function login(){
            
            $form=$this->createForm();
            $form->open(BASE.'user/log')
                ->label('Email:')
                ->input('email','email',['class'=>'form-control mb-3'])
                ->label('Password:')
                ->input('password','passw',['class'=>'form-control mb-3'])
                ->csrf($this->session->get('csrf-token'))
                ->submit('Sign')
                ->close();

            $this->render([
                'form'=>$form],'login');
        }
        /**
         * renders user's dashboard
         *
         * @return void
         */
        function dashboard(){  
            $user=$this->session->get('user');
            $data=$this->getDB()->selectWhereWithJoin('posts','users',['posts.id','posts.title'],'user','id',['users.username',$user['username']]);
            $this->render(['user'=>$user,'data'=>$data],'dashboard');
        }

        public function register(){
            $form=$this->createForm();
            $form->open(BASE.'user/reg')
                ->label('Username:')
                ->input('text','username',['class'=>'form-control mb-3'])
                ->label('Email:')
                ->input('email','email',['class'=>'form-control mb-3'])
                ->label('Password:')
                ->input('password','passwd',['class'=>'form-control mb-3'])
                ->label('Repeat password:')
                ->input('password','passwd2',['class'=>'form-control mb-3'])
                ->csrf($this->session->get('csrf-token'))
                ->submit('Sign up')
                ->close();
            //$user=$this->session->get('user');
            $this->render([
                'form'=>$form],'register');
        }
        public function profile(){
            $user=$this->session->get('user');
            $this->render(['user'=>$user],'profile');            

        }
        // funcions post -render
        function logout(){
            session_destroy();
            header('Location:'.BASE);
        }
        

        function log(){
           if( $this->csrfCheck()){
            if (isset($_POST['email'])&&!empty($_POST['email'])
            &&isset($_POST['passw'])&&!empty($_POST['passw']))
            {
                $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
                $pass=filter_input(INPUT_POST,'passw',FILTER_SANITIZE_STRING);
            
           
                $user=$this->auth($email,$pass);
                
                if ($user){
                    $this->session->set('user',$user);
                    //si usuari valid
                    if(isset($_POST['remember-me'])&&($_POST['remember-me']=='on'||$_POST['remember-me']=='1' )&& !isset($_COOKIE['remember'])){
                        $hour = time()+3600 *24 * 30;
                        $path=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
                        var_dump($path);
                        die;
                        setcookie('username', $user['username'], $hour,$path);
                        setcookie('email', $user['email'], $hour,$path);
                        setcookie('active', 1, $hour,$path);          
                    }
                    header('Location:'.BASE.'user/dashboard');
                }
                else{
                    header('Location:'.BASE.'user/login');
                }
            
            }
           }
            
        }
        
        public function reg(){
           
            if(isset($_POST['email'])&&!empty($_POST['email'])&&
                isset($_POST['username'])&&!empty($_POST['username'])&&
                isset($_POST['passwd'])&&!empty($_POST['passwd']))
            {
                
                $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
                $passwd=filter_input(INPUT_POST,'passwd',FILTER_SANITIZE_STRING);
                $passwd2=filter_input(INPUT_POST,'passwd2',FILTER_SANITIZE_STRING);
                $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
                
                if ($passwd===$passwd2){
                    
                    $passwd=password_hash($passwd,PASSWORD_BCRYPT,['cost'=>4]);
                    $data=[

                        'username'=>$username,
                        'role'=>2,
                        'email'=>$email,
                        'passwd'=>$passwd,
                        'createdAt'=>date('Y-m-d H:i:s')
                    ];
                    
                    // insert en db
                    if ($this->getDB()->insert('users',$data)){
                        header('Location:'.BASE);
                    }
                
                }
            }else{
                header('Location:'.BASE.'user/register');
            }
        }
        /**
         * Auth function
         *
         * @param [string] $email
         * @param [string] $pass
         * @return void
         */
        private function auth($email,$pass)
        {
            
            try{   
                $db=$this->getDB();
                $stmt=$db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1');
                $stmt->execute([':email'=>$email]);
                $count=$stmt->rowCount();
                $row=$stmt->fetchAll(\PDO::FETCH_ASSOC);  
                
                if($count==1){       
                    $user=$row[0];
                    $res=password_verify($pass,$user['passwd']);
                
                    if ($res){
                        return $user;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }catch(\PDOException $e){
                return false;
            }
        }
       
    }