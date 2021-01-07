<?php
    // crea el esquema
 
    require __DIR__.'/vendor/autoload.php';
    
    use App\App;
    if($argv[1]=='pro'){
        $conf=App::init('pro');
        $sql=file_get_contents($argv[2]);
    }else{
        $sql=file_get_contents($argv[1]);
    }
    
   

    define('DSN',$conf['driver'].':host='.$conf['dbhost'].';dbname='.$conf['dbname']);
    define('USR',$conf['dbuser']);
    define('PWD',$conf['dbpass']);

    $db=new \PDO(DSN,USR,PWD);
    
   
    try{
        $db->exec($sql);
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
    