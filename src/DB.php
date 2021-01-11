<?php

    namespace App;

    class DB extends \PDO{
        static $instance;
        protected  $config;

        static function singleton(){
            if(!(self::$instance instanceof self)){
                self::$instance=new self();
            }
            return self::$instance;
        }

        public function __construct(){
            parent::__construct(DSN,USR,PWD);
        }
        
       
        // Db functions
        function insert($table,$data)
        {
           if (is_array($data)){
              $columns='';$bindv='';$values=null;
                foreach ($data as $column => $value) {
                    $columns.='`'.$column.'`,';
                    $bindv.='?,';
                    $values[]=$value;
                }
                $columns=substr($columns,0,-1);
                $bindv=substr($bindv,0,-1);
                
                
                //var_dump($columns,$bindv,$values);
                
               
                $sql="INSERT INTO {$table}({$columns}) VALUES ({$bindv})";
              
                    try{
                        $stmt=self::$instance->prepare($sql);
                       
                        $res=$stmt->execute($values);
                       
                    }catch(\PDOException $e){
                        return $e->getMessage();
                       
                    }
                
                  return true;
                }
                return false;
            }
    
            function selectAll($table,array $fields=null):array
            {
                if (is_array($fields)){
                    $columns=implode(',',$fields);
                    
                }else{
                    $columns="*";
                }
                
                $sql="SELECT {$columns} FROM {$table}";
               
                $stmt=self::$instance->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $rows;
            }
    
            function selectWhere($table,array $fields=null,array $conds=null):array
            {
                if (is_array($fields)){
                    $columns=implode(',',$fields);
                    
                }else{
                    $columns="*";
                }
                if (is_array($conds)){
                
                    foreach($conds as $key=>$value){
                        $condition="{$key}='{$value}'";
                    }
                
                }
                
                $sql="SELECT {$columns} FROM {$table} WHERE {$condition}";
               
                $stmt=self::$instance->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $rows;
            }
            
            function selectAllWithJoin($table1,$table2,array $fields=null,string $join1,string $join2):array
            {
                if (is_array($fields)){
                    $columns=implode(',',$fields);
                    
                }else{
                    $columns="*";
                }
               
                $inners="{$table1}.{$join1} = {$table2}.{$join2}";
                
                $sql="SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners}";
                
                $stmt=self::$instance->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $rows;
            }
            // només una condició
            function selectWhereWithJoin($table1,$table2,array $fields=null,string $join1,string $join2,array $conditions):array
            {
                if (is_array($fields)){
                    $columns=implode(',',$fields);
                    
                }else{
                    $columns="*";
                }
               
                $inners="{$table1}.{$join1} = {$table2}.{$join2}";
                $cond="{$conditions[0]}='{$conditions[1]}'";
                
            $sql="SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners} WHERE {$cond} ";
            
                
                $stmt=self::$instance->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $rows;   
            }
    
            function update(string $table, array $data,array $conditions)
            {
                if ($data){
                    $keys=array_keys($data);
                    $values=array_values($data);
                    $changes="";
                    for($i=0;$i<count($keys);$i++){
                        $changes.=$keys[$i]."='".$values[$i]."',";
                    }
                    $changes=substr($changes,0,-1);
                    $cond="{$conditions[0]}='{$conditions[1]}'";
                    $sql="UPDATE {$table} SET {$changes} WHERE {$cond}";
                    
                    $stmt=self::$instance->prepare($sql);
                    $res=$stmt->execute();
                    if($res){
                        return true;
                    }    
                }else{
                    return false;
                }
                
    
            }
    
            function remove($tbl,$id){
            
                $sql="DELETE FROM {$tbl} WHERE id=$id";
                $stmt=self::$instance->prepare($sql);
                $res=$stmt->execute();
                if($res){
                    return true;
                }
                else{
                    return false;
                }    
            }
    }